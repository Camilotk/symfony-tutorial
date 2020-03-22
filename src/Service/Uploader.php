<?php


namespace App\Service;


use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    public function uploadFile(UploadedFile $file)
    {
        // cria um nome único para cada imagem
        // isso evita conflitos caso 2 tenham mesmo nome
        $filename = md5(uniqid()) . '.' . $file->guessClientExtension();

        // move as imagens, pega o valor de uploads_dir em services.yaml
        // e renomeia o arquivo com o valor em $filename
        $file->move($this->container->getParameter('uploads_dir'), $filename);

        return $filename;
    }
}