<?php

namespace App\Application\RabbitMq;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Serializer\Exception\UnsupportedFormatException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractConsumer implements ConsumerInterface
{
    private readonly EntityManagerInterface $entityManager;
    private readonly ValidatorInterface $validator;
    private readonly SerializerInterface $serializer;

    private readonly ManagerRegistry $doctrine;

    abstract protected function getMessageClass(): string;

    abstract protected function handle($message): int;

    #[Required]
    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }

    #[Required]
    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    #[Required]
    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }

    #[Required]
    public function setDoctrine(ManagerRegistry $doctrine): void
    {
        $this->doctrine = $doctrine;
    }

    public function execute(AMQPMessage $msg): int
    {
        try {
            $message = $this->serializer->deserialize($msg->getBody(), $this->getMessageClass(), 'json');

            $errors = $this->validator->validate($message);
            if ($errors->count() > 0) {
                return $this->reject((string)$errors);
            }

            return $this->handle($message);
        //} catch (UnsupportedFormatException $e) {
        } catch (\Throwable $e) {
            return $this->reject($e->getMessage());
        } finally {
            $this->entityManager->clear();
            $this->entityManager->getConnection()->close();

            $this->doctrine->resetManager();
        }
    }

    protected function reject(string $error): int
    {
        echo "Incorrect message: $error";

        return self::MSG_REJECT;
    }
}
