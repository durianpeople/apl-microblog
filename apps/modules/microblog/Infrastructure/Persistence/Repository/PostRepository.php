<?php

namespace Microblog\Infrastructure\Persistence\Repository;

use Common\Structure\WatchableList;
use Microblog\Core\Domain\Exception\NotFoundException;
use Microblog\Core\Domain\Interfaces\IPostRepository as IPostRepository;
use Microblog\Core\Domain\Model\Post\Hashtag;
use Microblog\Core\Domain\Model\Post\Post;
use Microblog\Core\Domain\Model\Post\PostID;
use Microblog\Core\Domain\Model\User\UserID;
use Microblog\Infrastructure\Persistence\Mapper\PostMapper;
use Microblog\Infrastructure\Persistence\Record\HashtagRecord;
use Microblog\Infrastructure\Persistence\Record\PostRecord;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\Model\Query;
use Phalcon\Mvc\Model\Transaction\Manager;

class PostRepository implements IPostRepository
{
    protected DiInterface $di;

    public function __construct(DiInterface $di)
    {
        $this->di = $di;
    }

    public function find(PostID $post_id): Post
    {
        $post_record = PostRecord::findFirst([
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $post_id->getString()
            ]
        ]);

        if ($post_record == null)
            throw new NotFoundException;

        return PostMapper::toModel($post_record);
    }

    public function all(): array
    {
        $post_records = PostRecord::find();

        $posts = [];
        foreach ($post_records as $pr) {
            $posts[] = PostMapper::toModel($pr);
        }

        return $posts;
    }

    public function getAllHashtags(): array
    {
        $hashtags = new WatchableList(Hashtag::class);
        foreach (HashtagRecord::find() as $hr) {
            /** @var HashtagRecord $hr */
            $hashtags->add(new Hashtag($hr->hashtag));
        }

        return $hashtags->getCurrentItems();
    }

    public function getPostsByHastag(Hashtag $hashtag): array
    {
        $query = new Query(
            'SELECT Microblog\Infrastructure\Persistence\Record\PostRecord.*
            FROM Microblog\Infrastructure\Persistence\Record\PostRecord
            JOIN Microblog\Infrastructure\Persistence\Record\HashtagRecord
            ON Microblog\Infrastructure\Persistence\Record\HashtagRecord.post_id = Microblog\Infrastructure\Persistence\Record\PostRecord.id
            AND Microblog\Infrastructure\Persistence\Record\HashtagRecord.hashtag = \'' . $hashtag->getString() . '\'',
            $this->di
        );

        /** @var PostRecord[] */
        $post_records = $query->execute();

        $posts = [];

        foreach ($post_records as $pr) {
            $posts[] = PostMapper::toModel($pr);
        }

        return $posts;
    }

    public function getPostsByUserID(UserID $user_id): array
    {
        $post_records = PostRecord::find([
            'conditions' => 'poster_id = :id:',
            'bind' => [
                'id' => $user_id->getString()
            ]
        ]);
        
        /** @var Post[] */
        $posts = [];
        foreach ($post_records as $pr) {
            $posts[] = PostMapper::toModel($pr);
        }

        return $posts;
    }

    public function persist(Post $post)
    {
        $trx = (new Manager())->get();
        try {
            // Save post data
            $post_record = PostMapper::toPostRecord($post);
            $post_record->save();

            // Add likes to database
            $added_likes = PostMapper::toAddedLikesRecord($post);
            foreach ($added_likes as $added_like) {
                $added_like->save();
            }

            // Remove likes from database
            $removed_likes = PostMapper::toRemovedLikesRecord($post);
            foreach ($removed_likes as $removed_like) {
                $removed_like->delete();
            }

            // Clear all hashtags from database
            $post_record->hashtags->delete();

            // Re-add hashtags to database
            $hashtag_records = PostMapper::toHashtagRecord($post);
            foreach ($hashtag_records as $hr) {
                $hr->save();
            }

            $trx->commit();
        } catch (\Exception $e) {
            $trx->rollback();
            throw $e;
        }
    }

    public function delete(Post $post)
    {
        $trx = (new Manager())->get();
        try {
            $post_record = PostMapper::toPostRecord($post);
            $post_record->likes->delete();
            $post_record->hashtags->delete();
            $post_record->delete();

            $trx->commit();
        } catch (\Exception $e) {
            $trx->rollback();
            throw $e;
        }
    }
}
