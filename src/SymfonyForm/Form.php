<?php

namespace SymfonyForm;

use SymfonyForm\SimpleTemplateNameParser;

use Symfony\Component\Form\Forms;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Translation\Translator;
use SymfonyForm\Helper\TranslatorHelper;
use SymfonyForm\Helper\FormHelper;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Templating\TemplatingRendererEngine;
use Symfony\Component\Form\FormRenderer;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;

/**
 * Description of Form
 *
 * @author alex
 */
class Form
{

    /**
     * 
     * @param \Symfony\Component\Form\AbstractType $classForm
     * @param type $data
     * @return type
     */
    static public function createForm(AbstractType $classForm, $data = null)
    {
        $validator = Validation::createValidator();
        $formFactory = Forms::createFormFactoryBuilder()
                ->addExtension(new ValidatorExtension($validator))->getFormFactory();
        $form        = $formFactory->create($classForm, $data);
        
        return $form;
    }
    
    static public function createFormHTML(AbstractType $classForm, $data = null)
    {
        $pathToView = __DIR__ . '/views/Form';
        $translator = new Translator('en');

        $engine = new PhpEngine(new SimpleTemplateNameParser($pathToView), new FilesystemLoader(array()));

        $template    = new TemplatingRendererEngine($engine, array($pathToView . '/Form'));
        $render      = new FormRenderer($template);
        $form_helper = new FormHelper($render);

        $engine->addHelpers(array(new TranslatorHelper($translator),$form_helper));
        
        return $render->renderBlock(self::createForm($classForm, $data)->createView(), "form");
    }

}
