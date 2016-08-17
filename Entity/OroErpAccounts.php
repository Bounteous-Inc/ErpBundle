<?php

namespace DemacMedia\Bundle\ErpBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\OrganizationBundle\Entity\Organization;
use Oro\Bundle\UserBundle\Entity\User;
use OroCRM\Bundle\AccountBundle\Entity\Account;
use OroCRM\Bundle\ContactBundle\Entity\Contact;

use DemacMedia\Bundle\ErpBundle\Model\ExtendOroErpAccounts;


/**
 * OroErpAccounts
 *
 * @ORM\Table(name="demacmedia_erp_accounts")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @Config(
 *      defaultValues={
 *          "entity"={
 *              "icon"="icon-ok-circle",
 *              "contact_information"={
 *                  "email"={
 *                      {"fieldName"="originalEmail"}
 *                  }
 *              },
 *              "label"="Erp Account",
 *              "plural_label"="Erp Accounts",
 *              "description"="Erp Accounts"
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
class OroErpAccounts extends ExtendOroErpAccounts
{
    const ENTITY_NAME = 'DemacMedia\Bundle\ErpBundle\Entity\OroErpAccounts';

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
     * @ORM\Column(name="account_number", type="integer")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Account Number",
     *              "plural_label"="Account Number",
     *              "description"="Account Number"
     *          }
     *      }
     * )
     */
    protected $accountNumber;


    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="First Name",
     *              "plural_label"="First Names",
     *              "description"="First Name"
     *          }
     *      }
     * )
     */
    protected $firstName;


    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Last Name",
     *              "plural_label"="Last Names",
     *              "description"="Last Name"
     *          }
     *      }
     * )
     */
    protected $lastName;


    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Email",
     *              "plural_label"="Emails",
     *              "description"="Emails"
     *          }
     *      }
     * )
     */
    protected $email;


    /**
     * @var string
     *
     * @ORM\Column(name="original_email", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Original Email",
     *              "plural_label"="Original Emails",
     *              "description"="Original Emails"
     *          }
     *      }
     * )
     */
    protected $originalEmail;


    /**
     * @var Collection|OroErpOrders[]
     *
     * @ORM\OneToMany(targetEntity="OroErpOrders", mappedBy="erpaccount", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $orders;


    /**
     * @var Collection|OroErpCarts[]
     *
     * @ORM\OneToMany(targetEntity="OroErpCarts", mappedBy="erpaccount", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $carts;


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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Account Created At",
     *              "plural_label"="Account Created At",
     *              "description"="Account Created At"
     *          }
     *      }
     * )
     */
    protected $createdAt;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Account Updated At",
     *              "plural_label"="Account Updated At",
     *              "description"="Account Updated At"
     *          }
     *      }
     * )
     */
    protected $updatedAt;


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


    /**
     * @var Account
     *
     * @ORM\ManyToOne(targetEntity="OroCRM\Bundle\AccountBundle\Entity\Account")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "excluded"=true
     *          }
     *      }
     * )
     */
    protected $account;


    /**
     * @var Contact
     *
     * @ORM\ManyToOne(targetEntity="OroCRM\Bundle\ContactBundle\Entity\Contact")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "excluded"=true
     *          }
     *      }
     * )
     */
    protected $contact;


    /**
     * @var float
     *
     * @ORM\Column(name="lifetime", type="money", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "excluded"=true
     *          }
     *      }
     * )
     */
    protected $lifetime = 0;


    /**
     * @var float
     *
     * @ORM\Column(name="lifetimeall", type="money", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "excluded"=true
     *          }
     *      }
     * )
     */
    protected $lifetimeall = 0;

    
    public function __construct() {
        $this->orders = new ArrayCollection();
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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
    public function setOwner(User $owner = null)
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
     * @param Contact $contact
     *
     * @return OroErpAccounts
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
        return $this;
    }

    /**
     * @return OroErpAccounts
     */
    public function getContact()
    {
        return $this->contact;
    }
    /**
     * @param Account $account
     *
     * @return OroErpAccounts
     */

    public function setAccount($account)
    {
        $this->account = $account;
        return $this;
    }
    /**
     * @return OroErpAccounts
     */
    public function getAccount()
    {
        return $this->account;
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
     * Returns accounts's name
     *
     * @return string
     */
    public function getName()
    {
        return sprintf("% %", $this->firstName, $this->lastName);
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
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @param int $accountNumber
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
    }

    /**
     * @return Collection|OroErpOrders[]
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param OroErpOrders $order
     *
     * @return $this
     */
    public function addOrder(OroErpOrders $order)
    {
        $this->orders->add($order);
        $order->setErpaccount($this);
        return $this;
    }

    /**
     * @return Collection|OroErpCarts[]
     */
    public function getCarts()
    {
        return $this->carts;
    }

    /**
     * @param OroErpCarts $cart
     *
     * @return $this
     */
    public function addCart(OroErpCarts $cart)
    {
        $this->carts->add($cart);
        $cart->setErpaccount($this);
        return $this;
    }

    /**
     * @param double $lifetime
     *
     * @return Customer
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = $lifetime;
        return $this;
    }

    /**
     * @return double
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * @param OroErpOrders $order
     *
     * @return $this
     */
    public function removeOrder(OroErpOrders $order)
    {
        $this->orders->removeElement($order);
        return $this;
    }

    /**
     * @return float
     */
    public function getLifetimeall()
    {
        return $this->lifetimeall;
    }

    /**
     * @param float $lifetimeall
     */
    public function setLifetimeall($lifetimeall)
    {
        $this->lifetimeall = $lifetimeall;
    }


}
