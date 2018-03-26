<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 25/03/2018
 * Time: 12:33
 */

namespace App\Controller;


use App\Service\ProductMercadoLivre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterProductController extends Controller
{
    /**
     * @var ProductMercadoLivre
     */
    private $productMercadoLivre;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(ProductMercadoLivre $productMercadoLivre, ValidatorInterface $validator)
    {
        $this->productMercadoLivre = $productMercadoLivre;
        $this->validator = $validator;
    }

    public function register(Request $request)
    {
        //try {

            $data = json_decode($request->getContent(), true);

            $errors = $this->valid($data);

            if (count($errors)) {
                return new JsonResponse(['error' => $errors], 400);
            }

            $this->productMercadoLivre->register($data);

            return new JsonResponse(['message' => 'Produto adicionado com sucesso']);

        //} catch (\Exception $e) {

          //  return new JsonResponse(['error' => $e->getMessage()], 400);

        //}

    }

    protected function valid($input)
    {
        $rules = [
            'missingFieldsMessage' => 'Campo obrigatório',
            'fields' => [
                'link' => [
                    new NotBlank(
                        [
                            'message' => 'Campo obrigatório'
                        ]
                    )
                ],
                'email' => [
                    new NotBlank(
                        [
                            'message' => 'Campo obrigatório'
                        ]
                    )
                ]
            ]
        ];


        $constraint = new Collection($rules);

        $valid = $this->validator->validate($input, $constraint);

        $errors = [];

        if (count($valid)) {

            foreach ($valid as $v) {

                $errors[] = $this->handlerMessage($v);

            }

        }

        return $errors;
    }

    /**
     * Error message handler
     *
     * @param ConstraintViolation $v List Messages
     *
     * @return array
     */
    protected function handlerMessage(ConstraintViolation $v): array
    {
        return [
            'message' => $v->getMessage(),
            'field'   => $this->handlerField($v->getPropertyPath())
        ];
    }

    /**
     * String message handler
     *
     * @param string $string bad formatted string
     *
     * @return string
     */
    protected function handlerField(string $string): string
    {
        $replace = ['[', ']'];
        $element = explode("][", $string);

        if (!is_array($element)) {
            return str_replace($replace, "", $element);
        }

        $item = "";

        $count = count($element);
        foreach ($element as $key => $e) {
            $item .= str_replace($replace, "", $e);

            if ($key + 1 < $count) {
                $item .= ".";
            }
        }

        return $item;
    }
}