<?php

namespace App\Service\PictureHandler;

use App\Collection\PictureCollection;
use App\Entity\Picture;
use App\Entity\PictureTranslation;
use App\Model\ContentModel;
use App\Model\PictureModel;
use App\Repository\PictureRepository;
use App\Repository\PictureTranslationRepository;
use App\Service\FileManager\FileManager;
use App\Service\FileManager\FileManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

class PictureHandler implements PictureHandlerInterface, PictureTranslationHandlerInterface
{
    private const UPLOADS_IMAGES_DIR = 'pictures/';

    /**
     * @var PictureRepository
     */
    private $pictureRepo;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var FileManager
     */
    private $fileUploader;
    /**
     * @var PictureTranslationRepository
     */
    private $pictureTranslationRepository;

    /**
     * PictureHandler constructor.
     * @param EntityManagerInterface $em
     * @param PictureRepository $repository
     * @param FileManagerInterface $fileManager
     * @param PictureTranslationRepository $pictureTranslationRepository
     */
    public function __construct(EntityManagerInterface $em,
                                PictureRepository $repository, FileManagerInterface $fileManager, PictureTranslationRepository $pictureTranslationRepository)
    {
        $this->em = $em;
        $this->pictureRepo = $repository;
        $this->fileUploader = $fileManager;
        $this->pictureTranslationRepository = $pictureTranslationRepository;
    }

    /**
     * @inheritDoc
     * @return PictureCollection
     */
    public function getAllPictures(): PictureCollection
    {
        return new PictureCollection($this->pictureRepo->findAll());
    }

    /**
     * @inheritDoc
     * @return PictureCollection
     */
    public function getPicturesInSlider(): PictureCollection
    {
        return new PictureCollection($this->pictureRepo->findPicturesInSlider());
    }

    /**
     * @inheritDoc
     * @param PictureModel $pictureModel
     */
    public function createPicture(PictureModel $pictureModel): void
    {
        $picture = new Picture();
        $picture->setPhoto($this->fileUploader->uploadFile($pictureModel->getPhoto(),self::UPLOADS_IMAGES_DIR));
        $this->em->persist($picture);
        $this->createPictureTranslation($picture,$pictureModel);
    }

    /**
     * @inheritDoc
     * @param Picture $picture
     * @param PictureModel $model
     */
    public function createPictureTranslation(Picture $picture, PictureModel $model): void
    {
        $pictureTrans = new PictureTranslation();
        $pictureTrans->setBody($model->getBody())
            ->setLocale($model->getLocale())
            ->setTitle($model->getTitle())
            ->setPicture($picture);

        $this->em->persist($pictureTrans);
        $this->em->flush();
    }

    public function getTranslationBy(?int $id): ?PictureTranslation
    {
        return $this->pictureTranslationRepository->find($id);
    }

    public function updateTranslation(PictureTranslation $pictureTranslation, ContentModel $model): void
    {
        $pictureTranslation->setTitle($model->getTitle())
            ->setBody($model->getBody());

        $this->em->flush();
    }

    public function deletePicture(Picture $picture): void
    {
        if ($picture) {
            $this->fileUploader->deleteFile(self::UPLOADS_IMAGES_DIR, $picture->getPhoto());
            $this->em->remove($picture);
            $this->em->flush();
        }
    }

    public function deleteTranslation(PictureTranslation $articleTranslation): void
    {
        $this->em->remove($articleTranslation);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     * @param int $picture
     * @param int $position
     */
    public function addPictureOnSlide(int $picture, int $position): void
    {
        $picture = $this->pictureRepo->find($picture);
        if($picture instanceof Picture){
            $picture->setSliderPosition($position);
            $this->em->flush();
        }
    }
}