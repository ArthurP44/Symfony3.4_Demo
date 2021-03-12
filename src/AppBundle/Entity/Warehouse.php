<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="warehouses",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="warehouses_type_category_unique", columns={"type", "category_id"})}
 * )
 */
class Warehouse
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $shippingFees;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $country;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="warehouses")
     * @var Category
     */
    protected $category;

    /**
     * @return mixed
     */
    public function getShippingFees()
    {
        return $this->shippingFees;
    }

    /**
     * @param mixed $shippingFees
     */
    public function setShippingFees($shippingFees)
    {
        $this->shippingFees = $shippingFees;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}