<?php

namespace IDCI\Bundle\KeycloakSecurityBundle\EventListener;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Component\HttpFoundation\RedirectResponse;
 Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ExceptionListener
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof IdentityProviderException) {
            $event->setResponse(new RedirectResponse(
                $this->urlGenerator->generate(
                    'idci_security_auth_connect_keycloak',
                    [],
                    UrlGeneratorInterface::ABSOLUTE_URL
                )
            ));
        }
    }
}
