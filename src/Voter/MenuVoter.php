<?php

namespace App\Voter;

use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\Voter\VoterInterface;
// use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Voter based on the uri
 */
class MenuVoter implements VoterInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $request;

    // public function __construct(ContainerInterface $container)
    public function __construct(RequestStack $stack)
    {
        $this->request = $stack->getCurrentRequest();
    }

    /**
     * Checks whether an item is current.
     *
     * If the voter is not able to determine a result,
     * it should return null to let other voters do the job.
     *
     * @param ItemInterface $item
     * @return boolean|null
     */
    public function matchItem(ItemInterface $item): ?bool
    {
        $itemUri = $item->getUri();
        if (strlen($itemUri) > 1){
            if (strpos($this->request->getRequestUri(), $item->getUri()) === 0) {
                return true;
            }
        }
        return null;
    }
}