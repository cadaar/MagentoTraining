<?php
namespace Flavio\ContactUs\Model\Resolver\DataProvider;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Contact\Model\ConfigInterface;
use Magento\Contact\Model\MailInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject;

class Contactus
{
    private $dataPersistor;
    private $mail;
    private $formKey;

    public function __construct(
        ConfigInterface $contactsConfig,
        MailInterface $mail,
        DataPersistorInterface $dataPersistor,
        \Magento\Framework\Data\Form\FormKey $formKey
    ) {
        $this->mail = $mail;
        $this->dataPersistor = $dataPersistor;
        $this->formKey = $formKey;
    }

    public function contactUs($fullname,$email,$subject,$message){
        $thanks_message = [];
        try {
            $this->sendEmail($fullname,$email,$subject,$message);
        }catch (LocalizedException $e) {
        }
        $thanks_message['success_message']="Thanks for contacting us with your comments and questions. We'll respond to you very soon.";
        return $thanks_message;
    }

    private function sendEmail($fullname,$email,$telephone,$message)
    {
        $form_data = [];
        $form_data['name']      =   $fullname;
        $form_data['email']     =   $email;
        $form_data['telephone'] =   $telephone;
        $form_data['comment']   =   $message;
        $form_data['hideit']    =   "";
        $form_data['form_key']  =   $this->getFormKey();

        $this->mail->send(
            $email,
            ['data' => new DataObject($form_data)]
        );
    }

    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }
}
