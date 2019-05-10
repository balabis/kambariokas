<?php


namespace App\Form\DataTransformer;

use App\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

use App\Entity\User;

class UserToUsernameTransformer implements DataTransformerInterface
{
    protected $repository;

    public function __construct(Registry $doctrine)
    {
        $this->repository = $doctrine->getManager()->getRepository(User::class);
    }

    public function transform($value)
    {
        if (null === $value) {
            return null;
        }

        if (! $value instanceof User) {
            throw new UnexpectedTypeException($value, User::class);
        }

        return $value->getUsername();
    }

    public function reverseTransform($value)
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if (! is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        return $this->repository->findOneByUsername($value);
    }
}