<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\SwiftmailerBundle;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, \Swift_Mailer $mailer)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/email", name="email")
     */
    public function emailUser(Request $request, \Swift_Mailer $mailer)
    {

        dump($request);

        $params = array();
        $content = $request->getContent();

        dump($content);
        if (!empty($content))
        {
            $params = json_decode($content, true);
            dump($params);
        }

        $name = $request->request->get('name');
        $email = $request->request->get('email');

        $message = (new \Swift_Message('Welcome to UK'))
            ->setTo('patrickconrey@gmail.com')
            ->setFrom($this->getParameter('mailer_from'))
            ->setBody(
                $this->renderView(
                    'Emails/rush-contact-email.html.twig',
                    array('name' => $name)
                ),
                'text/html'
            )
            ->attach(
                \Swift_Attachment::fromPath('/Users/patrickconrey/Documents/Symfony-Projects/fraternity_email_client/web/attachments/Informational-Packet.pdf')->setFilename('DeltaSigmaPhiInfo.pdf')
            )
            ->attach(
                \Swift_Attachment::fromPath('/Users/patrickconrey/Documents/Symfony-Projects/fraternity_email_client/web/attachments/Johnathon-Brigham-Scholarship-Application.pdf')->setFilename('DeltaSigmaPhiScholarship.pdf')
            );

        $mailer->send($message);

        return new Response('<html><body>hi</body></html>');
    }

    public function getAbsolutePath1()
    {
        return $this->getUploadRootDir();
    }
}
