<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Response\HashtagInfo;
use Microblog\Core\Domain\Interfaces\IPostRepository;

class ListAllHashtagService
{
    protected IPostRepository $repo;

    public function __construct(IPostRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @return HashtagInfo[]
     */
    public function execute(): array
    {
        $hashtags = [];
        foreach ($this->repo->getAllHashtags() as $h) {
            $hi = new HashtagInfo();
            $hi->hashtag = $h->getString();
            $hashtags[] = $hi;
        }

        return $hashtags;
    }
}