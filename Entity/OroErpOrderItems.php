<?php

namespace DemacMedia\Bundle\ErpBundle\Entity;

use Oro\Bundle\OrganizationBundle\Entity\Organization;
use Oro\Bundle\UserBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

/**
 * OroErpOrderItems
 *
 * @ORM\Table(name="demacmedia_erp_order_items")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @Config(
 *      defaultValues={
 *          "entity"={
 *              "icon"="icon-ok-circle",
 *              "label"="Erp Order Items",
 *              "plural_label"="Erp Order Items",
 *              "description"="Erp Order Items"
 *          },
 *      "security"={
 *          "type"="ACL"
 *      },
 *      "ownership"={
 *          "owner_type"="USER",
 *          "owner_field_name"="owner",
 *          "owner_column_name"="user_owner_id",
 *          "organization_field_name"="organization",
 *          "organization_column_name"="organization_id"
 *      }
 *  }
 * )
 */
class OroErpOrderItems
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="id",
     *              "plural_label"="ids",
     *              "description"="id"
     *          }
     *      }
     * )
     */
    protected $id;


    /**
     * @var string
     *
     * @ORM\Column(name="invno", type="string", length=32, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Inventory Number",
     *              "plural_label"="Inventories Number",
     *              "description"="Inventory Number"
     *          }
     *      }
     * )
     */
    protected $invno;

    /**
     * @var string
     *
     * @ORM\Column(name="custno", type="string", length=32, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Customer Number",
     *              "plural_label"="Customers Number",
     *              "description"="Customer Number"
     *          }
     *      }
     * )
     */
    protected $custno;

    /**
     * @var string
     *
     * @ORM\Column(name="item", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Item SKU",
     *              "plural_label"="Items SKU",
     *              "description"="Item SKU"
     *          }
     *      }
     * )
     */
    protected $item;

    /**
     * @var string
     *
     * @ORM\Column(name="descrip", type="string", length=32, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="descrip",
     *              "plural_label"="descrip",
     *              "description"="descrip"
     *          }
     *      }
     * )
     */
    protected $descrip;

    /**
     * @var float
     *
     * @ORM\Column(name="taxrate", type="percent", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Tax Rate",
     *              "plural_label"="Taxes Rate",
     *              "description"="Tax Rate"
     *          }
     *      }
     * )
     */
    protected $taxrate;

    /**
     * @var double
     *
     * @ORM\Column(name="cost", type="money", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Cost",
     *              "plural_label"="Costs",
     *              "description"="Cost"
     *          }
     *      }
     * )
     */
    protected $cost;

    /**
     * @var double
     *
     * @ORM\Column(name="price", type="money", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Price",
     *              "plural_label"="Prices",
     *              "description"="Price"
     *          }
     *      }
     * )
     */
    protected $price;


    /**
     * @var double
     *
     * @ORM\Column(name="extprice", type="money", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Ext Price",
     *              "plural_label"="Ext Prices",
     *              "description"="Ext Price"
     *          }
     *      }
     * )
     */
    protected $extprice;


    /**
     * @var float
     *
     * @ORM\Column(name="qtyord", type="float", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Quantity of order",
     *              "plural_label"="Quantities of orders",
     *              "description"="Quantity of order"
     *          }
     *      }
     * )
     */
    protected $qtyord;

    /**
     * @var float
     *
     * @ORM\Column(name="qtyshp", type="float", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Quantity of order shipped",
     *              "plural_label"="Quantities of orders shipped",
     *              "description"="Quantity of order shipped"
     *          }
     *      }
     * )
     */
    protected $qtyshp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="invdate", type="datetime", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Inventory Date",
     *              "plural_label"="Inventories Date",
     *              "description"="Inventory Date"
     *          }
     *      }
     * )
     */
    protected $invdate;

    /**
     * @var string
     *
     * @ORM\Column(name="ponum", type="string", length=32, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Ponum",
     *              "plural_label"="Ponum",
     *              "description"="Ponum"
     *          }
     *      }
     * )
     */
    protected $ponum;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Created At",
     *              "plural_label"="Created At",
     *              "description"="Created At"
     *          }
     *      }
     * )
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Updated At",
     *              "plural_label"="Updated At",
     *              "description"="Updated At"
     *          }
     *      }
     * )
     */
    protected $updated;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_owner_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "excluded"=true
     *          },
     *          "entity"={
     *              "label"="Owner",
     *              "plural_label"="Owners",
     *              "description"="Owner"
     *          }
     *      }
     * )
     */
    protected $owner;

    /**
     * @var Organization
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\OrganizationBundle\Entity\Organization")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "excluded"=true
     *          },
     *          "entity"={
     *              "label"="Organization",
     *              "plural_label"="Organizations",
     *              "description"="Organization"
     *          }
     *      }
     * )
     */
    protected $organization;






    /**
     * @return float
     */
    public function getQtyord()
    {
        return $this->qtyord;
    }

    /**
     * @param float $qtyord
     */
    public function setQtyord($qtyord)
    {
        $this->qtyord = $qtyord;
    }

    /**
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param float $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return float
     */
    public function getExtprice()
    {
        return $this->extprice;
    }

    /**
     * @param float $extprice
     */
    public function setExtprice($extprice)
    {
        $this->extprice = $extprice;
    }



    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param string $item
     */
    public function setItem($item)
    {
        $this->item = $item;
    }

    /**
     * @return float
     */
    public function getQtyshp()
    {
        return $this->qtyshp;
    }

    /**
     * @param float $qtyshp
     */
    public function setQtyshp($qtyshp)
    {
        $this->qtyshp = $qtyshp;
    }



    /**
     * @return string
     */
    public function getDescrip()
    {
        return $this->descrip;
    }

    /**
     * @param string $descrip
     */
    public function setDescrip($descrip)
    {
        $this->descrip = $descrip;
    }


    /**
     * @return string
     */
    public function getInvno()
    {
        return $this->invno;
    }

    /**
     * @param string $invno
     */
    public function setInvno($invno)
    {
        $this->invno = $invno;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustno()
    {
        return $this->custno;
    }

    /**
     * @param string $custno
     */
    public function setCustno($custno)
    {
        $this->custno = $custno;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getInvdate()
    {
        return $this->invdate;
    }

    /**
     * @param \DateTime $invdate
     */
    public function setInvdate($invdate)
    {
        $this->invdate = $invdate;

        return $this;
    }

    /**
     * @return string
     */
    public function getPonum()
    {
        return $this->ponum;
    }

    /**
     * @param string $ponum
     */
    public function setPonum($ponum)
    {
        $this->ponum = $ponum;
    }



    /**
     * @return float
     */
    public function getTaxrate()
    {
        return $this->taxrate;
    }

    /**
     * @param float $taxrate
     */
    public function setTaxrate($taxrate)
    {
        $this->taxrate = $taxrate;

        return $this;
    }

    /**
     * @return float
     */
    public function getInvamt()
    {
        return $this->invamt;
    }

    /**
     * @param float $invamt
     */
    public function setInvamt($invamt)
    {
        $this->invamt = $invamt;

        return $this;
    }

    /**
     * Get created date
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set created date
     *
     * @param \DateTime $date
     * @return $this
     */
    public function setCreated(\DateTime $date)
    {
        $this->created = $date;

        return $this;
    }

    /**
     * Get updated date
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set updated date
     *
     * @param \DateTime $date
     * @return $this
     */
    public function setUpdated(\DateTime $date)
    {
        $this->updated = $date;

        return $this;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     * @return OroErpAccounts
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get organization
     *
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Set organization
     *
     * @param Organization $organization
     * @return OroErpAccounts
     */
    public function setOrganization(Organization $organization = null)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return get_class();
    }

    /**
     * Pre persist event listener
     *
     * @ORM\PrePersist
     */
    public function beforeSave()
    {
        $this->created = new \DateTime('now', new \DateTimeZone('UTC'));
        $this->updated = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    /**
     * Pre update event handler
     * @ORM\PreUpdate
     */
    public function doUpdate()
    {
        $this->updated = new \DateTime('now', new \DateTimeZone('UTC'));
    }
}
