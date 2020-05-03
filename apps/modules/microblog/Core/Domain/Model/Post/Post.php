<?php

namespace Microblog\Core\Domain\Model\Post;

use Common\Structure\WatchableList;
use DateTime;
use Microblog\Core\Domain\Model\User\UserID;
use Microblog\Core\Domain\Model\User\Username;

/**
 * @property-read PostID $id
 * @property-read DateTime $created_at
 * @property-read UserID $poster_id
 * @property-read string $content
 * @property-read Username[] $mentions
 * @property-read Hashtag[] $hashtags
 * @property-read int $likes_count
 * @property-read Like[] $added_likes
 * @property-read Like[] $removed_likes
 */
class Post
{
    protected PostID $id;
    protected DateTime $created_at;
    protected UserID $poster_id;
    protected string $content;
    /** @var Username[] */
    protected array $mentions = [];
    /** @var Hashtag[] */
    protected array $hashtags = [];
    protected WatchableList $likes;
    protected int $likes_count;

    public static function create(UserID $poster_id, string $post_content)
    {
        return new Post(PostID::generate(), new DateTime(), $poster_id, $post_content, 0);
    }

    public function __construct(PostID $id, DateTime $created_at, UserID $poster_id, string $content, int $likes_count)
    {
        $this->id = $id;
        $this->created_at = $created_at;
        $this->poster_id = $poster_id;
        $this->content = $content;
        $this->likes_count = $likes_count;

        $this->likes = new WatchableList(Like::class);

        $matches = [];
        preg_match_all('/(^|[^@\w])@(\w{1,15})/', $content, $matches);

        foreach ($matches[2] as $username) {
            $this->mentions[] = new Username($username);
        }

        preg_match_all('/(^|[^#\w])#(\w{1,15})/', $content, $matches);

        foreach ($matches[2] as $hashtag) {
            $this->hashtags[] = new Hashtag($hashtag);
        }
    }

    public function __get($name)
    {
        switch ($name) {
            case 'id':
                return $this->id;
            case 'created_at':
                return $this->created_at;
            case 'poster_id':
                return $this->poster_id;
            case 'content':
                return $this->content;
            case 'mentions':
                return $this->mentions;
            case 'hashtags':
                return $this->hashtags;
            case 'likes_count':
                return $this->likes_count;
            case 'added_likes':
                return $this->likes->getAddedItems();
            case 'removed_likes':
                return $this->likes->getRemovedItems();
            default:
                throw new \RuntimeException();
        }
    }

    public function addLike(UserID $user_id)
    {
        $this->likes->add(new Like($user_id));
    }

    public function removeLike(UserID $user_id)
    {
        $this->likes->remove(new Like($user_id));
    }
}
