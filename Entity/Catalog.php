<?php

/*
 * This file is part of the Engage360d Catalog Bundle
 *
 * (c) Aliocha Ryzhkov <alioch@yandex.ru>
 */

namespace Engage360d\Bundle\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="BaseRepository")
 * @ORM\Table(name="catalogs")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Catalog
{
    const REPOSITORY = 'Engage360dCatalogBundle:Catalog';

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     *
     * @Groups({"getAllCatalogs", "getOneCatalog", "getCatalogId"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"getAllCatalogs", "getOneCatalog"})
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Record", mappedBy="catalog")
     *
     * @Groups({"getOneCatalog"})
     */
    protected $records;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->records = new ArrayCollection();
    }

    /**
     * Set id
     *
     * @param string $id
     * @return Catalog
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Catalog
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add records
     *
     * @param \Engage360d\Bundle\CatalogBundle\Entity\Record $records
     * @return Catalog
     */
    public function addRecord(\Engage360d\Bundle\CatalogBundle\Entity\Record $records)
    {
        $this->records[] = $records;
    
        return $this;
    }

    /**
     * Remove records
     *
     * @param \Engage360d\Bundle\CatalogBundle\Entity\Record $records
     */
    public function removeRecord(\Engage360d\Bundle\CatalogBundle\Entity\Record $records)
    {
        $this->records->removeElement($records);
    }

    /**
     * Get records
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecords()
    {
        return $this->records;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }
}