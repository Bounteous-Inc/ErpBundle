<?php

namespace DemacMedia\Bundle\ErpBundle\Entity;

use Oro\Bundle\OrganizationBundle\Entity\Organization;
use Oro\Bundle\UserBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

/**
 * OroErpOrders
 *
 * @ORM\Table(name="demacmedia_erp_orders")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @Config(
 *      defaultValues={
 *          "entity"={
 *              "icon"="icon-ok-circle",
 *              "label"="Erp Order",
 *              "plural_label"="Erp Orders",
 *              "description"="Erp Order"
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
class OroErpOrders
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
     * @ORM\Column(name="shipvia", type="string", length=32, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Shipvia",
     *              "plural_label"="Shipvia",
     *              "description"="Shipvia"
     *          }
     *      }
     * )
     */
    protected $shipvia;

    /**
     * @var string
     *
     * @ORM\Column(name="cshipno", type="string", length=32, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="cshipno",
     *              "plural_label"="cshipno",
     *              "description"="cshipno"
     *          }
     *      }
     * )
     */
    protected $cshipno;


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
     * @ORM\Column(name="tax", type="money", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Tax",
     *              "plural_label"="Taxes",
     *              "description"="Tax"
     *          }
     *      }
     * )
     */
    protected $tax;

    /**
     * @var float
     *
     * @ORM\Column(name="invamt", type="float", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Inventory Amount",
     *              "plural_label"="Inventories Amount",
     *              "description"="Inventory Amount"
     *          }
     *      }
     * )
     */
    protected $invamt;

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
     * @var string
     *
     * @ORM\Column(name="refno", type="string", length=32, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Refno",
     *              "plural_label"="Refno",
     *              "description"="Refno"
     *          }
     *      }
     * )
     */
    protected $refno;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=32, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Status",
     *              "plural_label"="Status",
     *              "description"="Order Status"
     *          }
     *      }
     * )
     */
    protected $status;

    /**
     * @var string
     *
     * @ORM\Column(name="salesrep", type="string", length=32, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Sales Representative",
     *              "plural_label"="Sales Representatives",
     *              "description"="Sales Representative"
     *          }
     *      }
     * )
     */
    protected $salesrep;

    /**
     * @var string
     *
     * @ORM\Column(name="shipname", type="string", length=64, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="shipname",
     *              "plural_label"="shipnames",
     *              "description"="shipname"
     *          }
     *      }
     * )
     */
    protected $shipname;

    /**
     * @var string
     *
     * @ORM\Column(name="shipcontact", type="string", length=64, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="shipcontact",
     *              "plural_label"="shipcontact",
     *              "description"="shipcontact"
     *          }
     *      }
     * )
     */
    protected $shipcontact;

    /**
     * @var string
     *
     * @ORM\Column(name="shipcontactphone", type="string", length=32, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="shipcontactphone",
     *              "plural_label"="shipcontactphone",
     *              "description"="shipcontactphone"
     *          }
     *      }
     * )
     */
    protected $shipcontactphone;

    /**
     * @var string
     *
     * @ORM\Column(name="shipaddr1", type="string", length=255, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="shipaddr1",
     *              "plural_label"="shipaddr1",
     *              "description"="shipaddr1"
     *          }
     *      }
     * )
     */
    protected $shipaddr1;

    /**
     * @var string
     *
     * @ORM\Column(name="shipaddr2", type="string", length=255, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="shipaddr2",
     *              "plural_label"="shipaddr2",
     *              "description"="shipaddr2"
     *          }
     *      }
     * )
     */
    protected $shipaddr2;

    /**
     * @var string
     *
     * @ORM\Column(name="shipcity", type="string", length=64, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="shipcity",
     *              "plural_label"="shipcity",
     *              "description"="shipcity"
     *          }
     *      }
     * )
     */
    protected $shipcity;

    /**
     * @var string
     *
     * @ORM\Column(name="shipstate", type="string", length=32, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="shipstate",
     *              "plural_label"="shipstate",
     *              "description"="shipstate"
     *          }
     *      }
     * )
     */
    protected $shipstate;

    /**
     * @var string
     *
     * @ORM\Column(name="shipzip", type="string", length=12, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="shipzip",
     *              "plural_label"="shipzip",
     *              "description"="shipzip"
     *          }
     *      }
     * )
     */
    protected $shipzip;

    /**
     * @var string
     *
     * @ORM\Column(name="shipcountry", type="string", length=64, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="shipcountry",
     *              "plural_label"="shipcountry",
     *              "description"="shipcountry"
     *          }
     *      }
     * )
     */
    protected $shipcountry;

    /**
     * @var string
     *
     * @ORM\Column(name="vendorno", type="string", length=48, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="vendorno",
     *              "plural_label"="vendorno",
     *              "description"="vendorno"
     *          }
     *      }
     * )
     */
    protected $vendorno;

    /**
     * @var string
     *
     * @ORM\Column(name="freight", type="string", length=32, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="freight",
     *              "plural_label"="freight",
     *              "description"="freight"
     *          }
     *      }
     * )
     */
    protected $freight;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateord", type="datetime", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="dateord",
     *              "plural_label"="dateord",
     *              "description"="dateord"
     *          }
     *      }
     * )
     */
    protected $dateord;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="estshpdate", type="datetime", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="estshpdate",
     *              "plural_label"="estshpdate",
     *              "description"="estshpdate"
     *          }
     *      }
     * )
     */
    protected $estshpdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="shipdate", type="datetime", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="shipdate",
     *              "plural_label"="shipdate",
     *              "description"="shipdate"
     *          }
     *      }
     * )
     */
    protected $shipdate;

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
     * @return \DateTime
     */
    public function getInvdte()
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
     * @param \DateTime $invdate
     */
    public function setInvdte($invdate)
    {
        $this->invdate = $invdate;

        return $this;
    }

    /**
     * @return string
     */
    public function getShipvia()
    {
        return $this->shipvia;
    }

    /**
     * @param string $shipvia
     */
    public function setShipvia($shipvia)
    {
        $this->shipvia = $shipvia;

        return $this;
    }

    /**
     * @return string
     */
    public function getCshipno()
    {
        return $this->cshipno;
    }

    /**
     * @param string $cshipno
     */
    public function setCshipno($cshipno)
    {
        $this->cshipno = $cshipno;

        return $this;
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
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param float $tax
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

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

        return $this;
    }

    /**
     * @return string
     */
    public function getRefno()
    {
        return $this->refno;
    }

    /**
     * @param string $refno
     */
    public function setRefno($refno)
    {
        $this->refno = $refno;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getSalesrep()
    {
        return $this->salesrep;
    }

    /**
     * @param string $salesrep
     */
    public function setSalesrep($salesrep)
    {
        $this->salesrep = $salesrep;
    }

    /**
     * @return string
     */
    public function getShipname()
    {
        return $this->shipname;
    }

    /**
     * @param string $shipname
     */
    public function setShipname($shipname)
    {
        $this->shipname = $shipname;
    }

    /**
     * @return string
     */
    public function getShipcontact()
    {
        return $this->shipcontact;
    }

    /**
     * @param string $shipcontact
     */
    public function setShipcontact($shipcontact)
    {
        $this->shipcontact = $shipcontact;
    }

    /**
     * @return string
     */
    public function getShipcontactphone()
    {
        return $this->shipcontactphone;
    }

    /**
     * @param string $shipcontactphone
     */
    public function setShipcontactphone($shipcontactphone)
    {
        $this->shipcontactphone = $shipcontactphone;
    }

    /**
     * @return string
     */
    public function getShipaddr1()
    {
        return $this->shipaddr1;
    }

    /**
     * @param string $shipaddr1
     */
    public function setShipaddr1($shipaddr1)
    {
        $this->shipaddr1 = $shipaddr1;
    }

    /**
     * @return string
     */
    public function getShipaddr2()
    {
        return $this->shipaddr2;
    }

    /**
     * @param string $shipaddr2
     */
    public function setShipaddr2($shipaddr2)
    {
        $this->shipaddr2 = $shipaddr2;
    }

    /**
     * @return string
     */
    public function getShipcity()
    {
        return $this->shipcity;
    }

    /**
     * @param string $shipcity
     */
    public function setShipcity($shipcity)
    {
        $this->shipcity = $shipcity;
    }

    /**
     * @return string
     */
    public function getShipstate()
    {
        return $this->shipstate;
    }

    /**
     * @param string $shipstate
     */
    public function setShipstate($shipstate)
    {
        $this->shipstate = $shipstate;
    }

    /**
     * @return string
     */
    public function getShipzip()
    {
        return $this->shipzip;
    }

    /**
     * @param string $shipzip
     */
    public function setShipzip($shipzip)
    {
        $this->shipzip = $shipzip;
    }

    /**
     * @return string
     */
    public function getShipcountry()
    {
        return $this->shipcountry;
    }

    /**
     * @param string $shipcountry
     */
    public function setShipcountry($shipcountry)
    {
        $this->shipcountry = $shipcountry;
    }

    /**
     * @return string
     */
    public function getVendorno()
    {
        return $this->vendorno;
    }

    /**
     * @param string $vendorno
     */
    public function setVendorno($vendorno)
    {
        $this->vendorno = $vendorno;
    }

    /**
     * @return string
     */
    public function getFreight()
    {
        return $this->freight;
    }

    /**
     * @param string $freight
     */
    public function setFreight($freight)
    {
        $this->freight = $freight;
    }

    /**
     * @return \DateTime
     */
    public function getDateord()
    {
        return $this->dateord;
    }

    /**
     * @param \DateTime $dateord
     */
    public function setDateord($dateord)
    {
        $this->dateord = $dateord;
    }

    /**
     * @return \DateTime
     */
    public function getEstshpdate()
    {
        return $this->estshpdate;
    }

    /**
     * @param \DateTime $estshpdate
     */
    public function setEstshpdate($estshpdate)
    {
        $this->estshpdate = $estshpdate;
    }

    /**
     * @return \DateTime
     */
    public function getShipdate()
    {
        return $this->shipdate;
    }

    /**
     * @param \DateTime $shipdate
     */
    public function setShipdate($shipdate)
    {
        $this->shipdate = $shipdate;
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
    public function setCreated(\DateTime $date = null)
    {
        if (!$date) {
            $this->created = new \DateTime('now', new \DateTimeZone('UTC'));
        } else {
            $this->created = $date;
        }

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
    public function setUpdated(\DateTime $date = null)
    {
        if (!$date) {
            $this->updated = new \DateTime('now', new \DateTimeZone('UTC'));
        } else {
            $this->updated = $date;
        }

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
