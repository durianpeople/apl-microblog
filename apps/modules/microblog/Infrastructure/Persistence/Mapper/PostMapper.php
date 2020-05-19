<?php

namespace Microblog\Infrastructure\Persistence\Mapper;

use DateTime;
use Microblog\Core\Domain\Model\Post\Like;
use Microblog\Core\Domain\Model\Post\Post;
use Microblog\Core\Domain\Model\Post\PostID;
use Microblog\Core\Domain\Model\User\UserID;
use Microblog\Core\Domain\Model\User\Username;
use Microblog\Infrastructure\Persistence\Record\HashtagRecord;
use Microblog\Infrastructure\Persistence\Record\LikesRecord;
use Microblog\Infrastructure\Persistence\Record\PostRecord;
use Microblog\Infrastructure\Persistence\Record\UserRecord;

class PostMapper
{
    public static function toPostRecord(Post $post): PostRecord
    {
        $post_record = new PostRecord;
        $post_record->id = $post->id->getString();
        $post_record->created_at = $post->created_at->getTimestamp();
        $post_record->poster_id = $post->poster_id->getString();
        $post_record->content = $post->content;

        return $post_record;
    }

    /**
     * @param Post $post
     * @return LikesRecord[]
     */
    public static function toAddedLikesRecord(Post $post): array
    {
        $likes_records = [];
        foreach ($post->added_likes as $l) {
            $lr = new LikesRecord();
            $lr->post_id = $post->id->getString();
            $lr->user_id = $l->user_id->getString();
            $likes_records[] = $lr;
        }

        return $likes_records;
    }

    /**
     * @param Post $post
     * @return LikesRecord[]
     */
    public static function toRemovedLikesRecord(Post $post): array
    {
        $likes_records = [];
        foreach ($post->removed_likes as $l) {
            /** @var Like $l */
            $lr = new LikesRecord();
            $lr->post_id = $post->id->getString();
            $lr->user_id = $l->user_id->getString();
            $likes_records[] = $lr;
        }

        return $likes_records;
    }

    /**
     * @param Post $post
     * @return HashtagRecord[]
     */
    public static function toHashtagRecord(Post $post): array
    {
        $hashtag_records = [];
        foreach ($post->hashtags as $h) {
            $hr = new HashtagRecord();
            $hr->post_id = $post->id->getString();
            $hr->hashtag = $h->getString();

            $hashtag_records[] = $hr;
        }

        return $hashtag_records;
    }

    public static function toModel(PostRecord $post_record): Post
    {
        /** @var UserRecord */
        $user_record = UserRecord::findFirst([
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $post_record->poster_id
            ]
        ]);

        return new Post(
            new PostID($post_record->id),
            (new DateTime())->setTimestamp($post_record->created_at),
            new UserID($post_record->poster_id),
            new Username($user_record->username),
            $post_record->content,
            $post_record->likes->count()
        );
    }
}