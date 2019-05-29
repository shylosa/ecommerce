<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Environment;

class Mailer
{
    /**
     * @var Environment
     */
    private $templating;
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var string
     */
    private $fromEmail;
    public function __construct(Environment $templating, \Swift_Mailer $mailer, ParameterBagInterface $parameterBag)
    {
        $this->templating = $templating;
        $this->mailer = $mailer;
        $this->fromEmail = $parameterBag->get('from_email');
    }
    public function sendMessage(string $template, array $to, array $context)
    {
        $twig = $this->templating->load($template);
        $subject = $twig->renderBlock('subject', $context);
        $body = $twig->renderBlock('body', $context);
        $message = new \Swift_Message();
        $message->setTo($to);
        $message->setSubject($subject);
        $message->setBody($body, 'text/html');
        $message->setFrom($this->fromEmail);
        $this->mailer->send($message);
    }
}