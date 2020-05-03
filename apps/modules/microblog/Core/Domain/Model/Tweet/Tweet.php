<?php

namespace Microblog\Core\Domain\Model\Tweet;

use Common\Structure\WatchableList;
use DateTime;
use Microblog\Core\Domain\Model\User\UserID;
use Microblog\Core\Domain\Model\User\Username;

/**
 * @property-read TweetID $id
 * @property-read DateTime $created_at
 * @property-read UserID $tweeter_id
 * @property-read string $content
 * @property-read Username[] $mentions
 * @property-read Hashtag[] $hashtags
 * @property-read int $likes_count
 * @property-read Like[] $added_likes
 * @property-read Like[] $removed_likes
 */
class Tweet
{
    protected TweetID $id;
    protected DateTime $created_at;
    protected UserID $tweeter_id;
    protected string $content;
    /** @var Username[] */
    protected array $mentions = [];
    /** @var Hashtag[] */
    protected array $hashtags = [];
    protected WatchableList $likes;
    protected int $likes_count;

    public static function create(UserID $tweeter_id, string $tweet_content)
    {
        return new Tweet(TweetID::generate(), new DateTime(), $tweeter_id, $tweet_content, 0);
    }

    public function __construct(TweetID $id, DateTime $created_at, UserID $tweeter_id, string $content, int $likes_count)
    {
        $this->id = $id;
        $this->created_at = $created_at;
        $this->tweeter_id = $tweeter_id;
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
            case 'tweeter_id':
                return $this->tweeter_id;
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
