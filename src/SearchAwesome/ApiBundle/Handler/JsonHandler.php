<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 17:05
 */

namespace SearchAwesome\ApiBundle\Handler;


use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonHandler
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function createResponse(ViewHandler $handler, View $view, Request $request)
    {
        $json = $this->serializer->serialize($view->getData(), 'json', $view->getSerializationContext());

        return new Response($json, Codes::HTTP_OK, $view->getHeaders());
    }
} 