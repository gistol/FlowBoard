<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 10/12/2018
 * Time: 20:18
 */

namespace App\Controller\ApiControllers\V1;

use App\Entity\Columns;
use App\Entity\ColumnStatus;
use App\Interfaces\ApiAuthenticationInterface;
use App\Responses\ApiResponses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ColumnController extends Controller implements ApiAuthenticationInterface
{

    public function getColumns() {

        $columns = $this->getDoctrine()->getRepository(ColumnStatus::class)->findAll();

        return ApiResponses::okResponse($columns);

    }

    public function createColumn(
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        Request $request
    ) {

        /** @var Columns $column */
        $column = $serializer->deserialize(
            $request->getContent(), Columns::class, 'json'
        );

        $errors = $validator->validate($column);

        // Check if there are any error's in the column
        if (count($errors) > 0) return ApiResponses::badRequest($errors[0]->getPropertyPath(), $errors[0]->getMessage());

        $status = $this->getDoctrine()->getRepository(ColumnStatus::class)->findOneBy([
            'id' => $column->getStatus()
        ]);

        if ($status === null) return ApiResponses::badRequest('status', 'status not valid');

        $column->setStatus($status);

        $orders = $this->getDoctrine()->getRepository(Columns::class)->findOrderGreaterThan(
            $column->getOrder(),
            $this->get('project')
        );

        $column->setProject($this->get('project'));

        $em = $this->getDoctrine()->getManager();

        /** @var Columns $order */
        foreach ($orders as $order) {
            $order->setOrder(intval($order->getOrder()) + 1);
        }

        $em->persist($column);

        $em->flush();

        return ApiResponses::okResponse($column);

    }

}