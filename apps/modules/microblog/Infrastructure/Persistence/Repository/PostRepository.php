<?php

namespace Microblog\Infrastructure\Persistence\Repository;

use Microblog\Core\Domain\Exception\NotFoundException;
use Microblog\Core\Domain\Interfaces\IPostRepository as IPostRepository;
use Microblog\Core\Domain\Model\Post\Post;
use Microblog\Core\Domain\Model\Post\PostID;
use Microblog\Infrastructure\Persistence\Mapper\PostMapper;
use Microblog\Infrastructure\Persistence\Record\PostRecord;
use Phalcon\Mvc\Model\Transaction\Manager;

class PostRepository implements IPostRepository
{
    public function find(PostID $post_id): Post
    {
        $post_record = PostRecord::findFirst([
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $post_id->getString()
            ]
        ]);

        if ($post_record == null) throw new NotFoundException;

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

    public function persist(Post $post)
    {
        $trx = (new Manager())->get();
        try {
            $post_record = PostMapper::toPostRecord($post);
            $post_record->save();

            $added_likes = PostMapper::toAddedLikesRecord($post);
            foreach ($added_likes as $added_like) {
                $added_like->save();
            }

            $removed_likes = PostMapper::toRemovedLikesRecord($post);
            foreach ($removed_likes as $removed_like) {
                $removed_like->delete();
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
            $post_record->delete();

            $trx->commit();
        } catch (\Exception $e) {
            $trx->rollback();
            throw $e;
        }
    }
}