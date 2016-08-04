<?php

namespace DemacMedia\Bundle\ErpBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Oro\Bundle\OrganizationBundle\Entity\Organization;
use Oro\Bundle\UserBundle\Entity\User;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

use DemacMedia\Bundle\ErpBundle\Entity\OroErpAccounts;

/**
 * OroErpCarts
 *
 * @ORM\Table(name="demacmedia_erp_carts")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @Config(
 *      defaultValues={
 *          "entity"={
 *              "icon"="icon-ok-circle",
 *              "label"="Erp Cart",
 *              "plural_label"="Erp Carts",
 *              "description"="Erp Cart"
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
class OroErpCarts
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
     * @var integer
     *
     * @ORM\Column(name="cart_number", type="integer")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Cart Number",
     *              "plural_label"="Carts Number",
     *              "description"="Cart Number"
     *          }
     *      }
     * )
     */
    protected $cartNumber;
    

    /**
     * @var OroErpAccounts
     *
     * @ORM\ManyToOne(targetEntity="OroErpAccounts", inversedBy="carts")
     * @ORM\JoinColumn(name="erpaccount_id", onDelete="CASCADE")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="WebStore Account(Original Email)",
     *              "plural_label"="WebStore Accounts(Original Email)",
     *              "description"="WebStore Account(Original Email)"
     *          }
     *      }
     * )
     */
    protected $erpaccount;


    /**
     * @var Collection|OroErpCarts[]
     *
     * @ORM\OneToMany(targetEntity="OroErpCartItems", mappedBy="cart", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $items;


    /**
     * @var double
     *
     * @ORM\Column(name="total_paid", type="money", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Total Paid",
     *              "plural_label"="Total Paid",
     *              "description"="Total Paid"
     *          }
     *      }
     * )
     */
    protected $totalPaid;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Cart Updated At",
     *              "plural_label"="Carts Updated At",
     *              "description"="Cart Updated At"
     *          }
     *      }
     * )
     */
    protected $updatedAt;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Cart Created At",
     *              "plural_label"="Carts Created At",
     *              "description"="Cart Created At"
     *          }
     *      }
     * )
     */
    protected $createdAt;


    /**
     * @var string
     *
     * @ORM\Column(name="original_email", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="WebStore Account(Original Email)",
     *              "plural_label"="Original Emails",
     *              "description"="Original Email"
     *          }
     *      }
     * )
     */
    protected $originalEmail;
    
    

    /**
     * @var string
     *
     * @ORM\Column(name="bill_firstname", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Bill First Name",
     *              "plural_label"="Bill First Names",
     *              "description"="Bill First Name"
     *          }
     *      }
     * )
     */
    protected $billFirstname;


    /**
     * @var string
     *
     * @ORM\Column(name="bill_lastname", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Bill Last Name",
     *              "plural_label"="Bill Last Names",
     *              "description"="Bill Last Name"
     *          }
     *      }
     * )
     */
    protected $billLastname;


    /**
     * @var string
     *
     * @ORM\Column(name="bill_company", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Bill Company",
     *              "plural_label"="Bill Companies",
     *              "description"="Bill Company"
     *          }
     *      }
     * )
     */
    protected $billCompany;


    /**
     * @var string
     *
     * @ORM\Column(name="bill_address1", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Bill Address1",
     *              "plural_label"="Bill Address1",
     *              "description"="Bill Address1"
     *          }
     *      }
     * )
     */
    protected $billAddress1;


    /**
     * @var string
     *
     * @ORM\Column(name="bill_address2", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Bill Address2",
     *              "plural_label"="Bill Address2",
     *              "description"="Bill Address2"
     *          }
     *      }
     * )
     */
    protected $billAddress2;


    /**
     * @var string
     *
     * @ORM\Column(name="bill_city", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Bill City",
     *              "plural_label"="Bill Cities",
     *              "description"="Bill City"
     *          }
     *      }
     * )
     */
    protected $billCity;


    /**
     * @var string
     *
     * @ORM\Column(name="bill_state", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Bill State",
     *              "plural_label"="Bill States",
     *              "description"="Bill State"
     *          }
     *      }
     * )
     */
    protected $billState;


    /**
     * @var string
     *
     * @ORM\Column(name="bill_zip", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Bill Zip",
     *              "plural_label"="Bill Zips",
     *              "description"="Bill Zip"
     *          }
     *      }
     * )
     */
    protected $billZip;


    /**
     * @var string
     *
     * @ORM\Column(name="bill_phone", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Bill Phone",
     *              "plural_label"="Bill Phones",
     *              "description"="Bill Phone"
     *          }
     *      }
     * )
     */
    protected $billPhone;


    /**
     * @var string
     *
     * @ORM\Column(name="ship_firstname", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Ship First Name",
     *              "plural_label"="Ship First Names",
     *              "description"="Ship First Name"
     *          }
     *      }
     * )
     */
    protected $shipFirstname;


    /**
     * @var string
     *
     * @ORM\Column(name="ship_lastname", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Ship Last Name",
     *              "plural_label"="Ship Last Names",
     *              "description"="Ship Last Name"
     *          }
     *      }
     * )
     */
    protected $shipLastname;


    /**
     * @var string
     *
     * @ORM\Column(name="ship_company", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Ship Company",
     *              "plural_label"="Ship Companies",
     *              "description"="Ship Company"
     *          }
     *      }
     * )
     */
    protected $shipCompany;


    /**
     * @var string
     *
     * @ORM\Column(name="ship_address1", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Ship Address1",
     *              "plural_label"="Ship Address1",
     *              "description"="Ship Address1"
     *          }
     *      }
     * )
     */
    protected $shipAddress1;


    /**
     * @var string
     *
     * @ORM\Column(name="ship_address2", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Ship Address2",
     *              "plural_label"="Ship Address2",
     *              "description"="Ship Address2"
     *          }
     *      }
     * )
     */
    protected $shipAddress2;


    /**
     * @var string
     *
     * @ORM\Column(name="ship_city", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Ship City",
     *              "plural_label"="Ship Cities",
     *              "description"="Ship City"
     *          }
     *      }
     * )
     */
    protected $shipCity;


    /**
     * @var string
     *
     * @ORM\Column(name="ship_state", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Ship State",
     *              "plural_label"="Ship States",
     *              "description"="Ship State"
     *          }
     *      }
     * )
     */
    protected $shipState;


    /**
     * @var string
     *
     * @ORM\Column(name="ship_zip", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Ship Zip",
     *              "plural_label"="Ship Zips",
     *              "description"="Ship Zip"
     *          }
     *      }
     * )
     */
    protected $shipZip;


    /**
     * @var string
     *
     * @ORM\Column(name="ship_phone", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Ship Phone",
     *              "plural_label"="Ship Phones",
     *              "description"="Ship Phone"
     *          }
     *      }
     * )
     */
    protected $shipPhone;


    /**
     * @var string
     *
     * @ORM\Column(name="completed_order_id", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Completed Order Id",
     *              "plural_label"="Completed Order Id",
     *              "description"="Completed Order Id"
     *          }
     *      }
     * )
     */
    protected $completedOrderId;


    /**
     * @var string
     *
     * @ORM\Column(name="cart_status", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Cart Status",
     *              "plural_label"="Cart Status",
     *              "description"="Cart Status"
     *          }
     *      }
     * )
     */
    protected $cartStatus;
    

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
     * @var string
     *
     * @ORM\Column(name="website_id", type="string", length=64)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Website ID",
     *              "plural_label"="Websites ID",
     *              "description"="Website ID"
     *          }
     *      }
     * )
     */
    protected $websiteId;


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


    public function __construct() {
        $this->items = new ArrayCollection();
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
    }

    /**
     * @return string
     */
    public function getOriginalEmail()
    {
        return $this->originalEmail;
    }

    /**
     * @param string $originalEmail
     */
    public function setOriginalEmail($originalEmail)
    {
        $this->originalEmail = $originalEmail;
    }

    /**
     * @return float
     */
    public function getTotalPaid()
    {
        return $this->totalPaid;
    }

    /**
     * @param float $totalPaid
     */
    public function setTotalPaid($totalPaid)
    {
        $this->totalPaid = $totalPaid;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getOriginalCartId()
    {
        return $this->originalCartId;
    }

    /**
     * @param int $originalCartId
     */
    public function setOriginalCartId($originalCartId)
    {
        $this->originalCartId = $originalCartId;
    }

    /**
     * @return string
     */
    public function getBillFirstname()
    {
        return $this->billFirstname;
    }

    /**
     * @param string $billFirstname
     */
    public function setBillFirstname($billFirstname)
    {
        $this->billFirstname = $billFirstname;
    }

    /**
     * @return string
     */
    public function getBillLastname()
    {
        return $this->billLastname;
    }

    /**
     * @param string $billLastname
     */
    public function setBillLastname($billLastname)
    {
        $this->billLastname = $billLastname;
    }

    /**
     * @return string
     */
    public function getBillCompany()
    {
        return $this->billCompany;
    }

    /**
     * @param string $billCompany
     */
    public function setBillCompany($billCompany)
    {
        $this->billCompany = $billCompany;
    }

    /**
     * @return string
     */
    public function getBillAddress1()
    {
        return $this->billAddress1;
    }

    /**
     * @param string $billAddress1
     */
    public function setBillAddress1($billAddress1)
    {
        $this->billAddress1 = $billAddress1;
    }

    /**
     * @return string
     */
    public function getBillAddress2()
    {
        return $this->billAddress2;
    }

    /**
     * @param string $billAddress2
     */
    public function setBillAddress2($billAddress2)
    {
        $this->billAddress2 = $billAddress2;
    }

    /**
     * @return string
     */
    public function getBillCity()
    {
        return $this->billCity;
    }

    /**
     * @param string $billCity
     */
    public function setBillCity($billCity)
    {
        $this->billCity = $billCity;
    }

    /**
     * @return string
     */
    public function getBillState()
    {
        return $this->billState;
    }

    /**
     * @param string $billState
     */
    public function setBillState($billState)
    {
        $this->billState = $billState;
    }

    /**
     * @return string
     */
    public function getBillZip()
    {
        return $this->billZip;
    }

    /**
     * @param string $billZip
     */
    public function setBillZip($billZip)
    {
        $this->billZip = $billZip;
    }

    /**
     * @return string
     */
    public function getBillPhone()
    {
        return $this->billPhone;
    }

    /**
     * @param string $billPhone
     */
    public function setBillPhone($billPhone)
    {
        $this->billPhone = $billPhone;
    }

    /**
     * @return string
     */
    public function getShipFirstname()
    {
        return $this->shipFirstname;
    }

    /**
     * @param string $shipFirstname
     */
    public function setShipFirstname($shipFirstname)
    {
        $this->shipFirstname = $shipFirstname;
    }

    /**
     * @return string
     */
    public function getShipLastname()
    {
        return $this->shipLastname;
    }

    /**
     * @param string $shipLastname
     */
    public function setShipLastname($shipLastname)
    {
        $this->shipLastname = $shipLastname;
    }

    /**
     * @return string
     */
    public function getShipCompany()
    {
        return $this->shipCompany;
    }

    /**
     * @param string $shipCompany
     */
    public function setShipCompany($shipCompany)
    {
        $this->shipCompany = $shipCompany;
    }

    /**
     * @return string
     */
    public function getShipAddress1()
    {
        return $this->shipAddress1;
    }

    /**
     * @param string $shipAddress1
     */
    public function setShipAddress1($shipAddress1)
    {
        $this->shipAddress1 = $shipAddress1;
    }

    /**
     * @return string
     */
    public function getShipAddress2()
    {
        return $this->shipAddress2;
    }

    /**
     * @param string $shipAddress2
     */
    public function setShipAddress2($shipAddress2)
    {
        $this->shipAddress2 = $shipAddress2;
    }

    /**
     * @return string
     */
    public function getShipCity()
    {
        return $this->shipCity;
    }

    /**
     * @param string $shipCity
     */
    public function setShipCity($shipCity)
    {
        $this->shipCity = $shipCity;
    }

    /**
     * @return string
     */
    public function getShipState()
    {
        return $this->shipState;
    }

    /**
     * @param string $shipState
     */
    public function setShipState($shipState)
    {
        $this->shipState = $shipState;
    }

    /**
     * @return string
     */
    public function getShipZip()
    {
        return $this->shipZip;
    }

    /**
     * @param string $shipZip
     */
    public function setShipZip($shipZip)
    {
        $this->shipZip = $shipZip;
    }

    /**
     * @return string
     */
    public function getShipPhone()
    {
        return $this->shipPhone;
    }

    /**
     * @param string $shipPhone
     */
    public function setShipPhone($shipPhone)
    {
        $this->shipPhone = $shipPhone;
    }

    /**
     * @return string
     */
    public function getCartStatus()
    {
        return $this->cartStatus;
    }

    /**
     * @param string $cartStatus
     */
    public function setCartStatus($cartStatus)
    {
        $this->cartStatus = $cartStatus;
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

    /**
     * @return int
     */
    public function getCartNumber()
    {
        return $this->cartNumber;
    }

    /**
     * @param int $cartNumber
     */
    public function setCartNumber($cartNumber)
    {
        $this->cartNumber = $cartNumber;
    }

    /**
     * @return \DemacMedia\Bundle\ErpBundle\Entity\OroErpAccounts
     */
    public function getErpaccount()
    {
        return $this->erpaccount;
    }

    /**
     * @param \DemacMedia\Bundle\ErpBundle\Entity\OroErpAccounts $erpaccount
     */
    public function setErpaccount($erpaccount)
    {
        $this->erpaccount = $erpaccount;
    }
    
    /**
     * @return Collection|OroErpCartItems[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param OroErpCartItems $item
     *
     * @return $this
     */
    public function addItem(OroErpCartItems $item)
    {
        $this->items->add($item);
        $item->setCart($this);
        return $this;
    }

    /**
     * @param OroErpCartItems $item
     *
     * @return $this
     */
    public function removeItem(OroErpCartItems $item)
    {
        $this->items->removeElement($item);
        return $this;
    }

    /**
     * @return string
     */
    public function getWebsiteId()
    {
        return $this->websiteId;
    }

    /**
     * @param string $websiteId
     */
    public function setWebsiteId($websiteId)
    {
        $this->websiteId = $websiteId;
    }

    /**
     * @return string
     */
    public function getCompletedOrderId()
    {
        return $this->completedOrderId;
    }

    /**
     * @param string $completedOrderId
     */
    public function setCompletedOrderId($completedOrderId)
    {
        $this->completedOrderId = $completedOrderId;
    }
}
