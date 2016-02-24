<?php

namespace DemacMedia\Bundle\ErpBundle\Entity;

use Oro\Bundle\OrganizationBundle\Entity\Organization;
use Oro\Bundle\UserBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use OroCRM\Bundle\AccountBundle\Entity\Account;
use OroCRM\Bundle\ContactBundle\Entity\Contact;


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
class OroErpAccounts
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
     * @ORM\Column(name="company", type="string", length=100, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Company",
     *              "plural_label"="Companies",
     *              "description"="Company"
     *          }
     *      }
     * )
     */
    protected $company;

    /**
     * @var string
     *
     * @ORM\Column(name="contactname", type="string")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="ContactName",
     *              "plural_label"="Contacts Name",
     *              "description"="Contact Name"
     *          }
     *      }
     * )
     */
    protected $contactname;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=32, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Title",
     *              "plural_label"="Titles",
     *              "description"="Title"
     *          }
     *      }
     * )
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="address1", type="string", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Address 1",
     *              "plural_label"="Addresses",
     *              "description"="Address 1"
     *          }
     *      }
     * )
     */
    protected $address1;

    /**
     * @var string
     *
     * @ORM\Column(name="address2", type="string", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Address 2",
     *              "plural_label"="Addresses",
     *              "description"="Address 2"
     *          }
     *      }
     * )
     */
    protected $address2;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=64)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="City",
     *              "plural_label"="Cities",
     *              "description"="City"
     *          }
     *      }
     * )
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(name="addrstate", type="string", length=2, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="State",
     *              "plural_label"="States",
     *              "description"="Address State"
     *          }
     *      }
     * )
     */
    protected $addrstate;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=10, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Zip",
     *              "plural_label"="Zip",
     *              "description"="Zip"
     *          }
     *      }
     * )
     */
    protected $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=64, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Country",
     *              "plural_label"="Countries",
     *              "description"="Country"
     *          }
     *      }
     * )
     */
    protected $country;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=32)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Phone",
     *              "plural_label"="Phones",
     *              "description"="Phone"
     *          }
     *      }
     * )
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="phone2", type="string", length=32, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Phone 2",
     *              "plural_label"="Phones",
     *              "description"="Phone 2"
     *          }
     *      }
     * )
     */
    protected $phone2;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=32, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Source",
     *              "plural_label"="Sources",
     *              "description"="Source"
     *          }
     *      }
     * )
     */
    protected $source;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=16, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Type",
     *              "plural_label"="Types",
     *              "description"="Type"
     *          }
     *      }
     * )
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Email",
     *              "plural_label"="Emails",
     *              "description"="Email"
     *          }
     *      }
     * )
     */
    protected $email;


    /**
     * @var string
     *
     * @ORM\Column(name="salesrep", type="string", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="salesrep",
     *              "plural_label"="salesrep",
     *              "description"="salesrep"
     *          }
     *      }
     * )
     */
    protected $salesrep;


    /**
     * @var string
     *
     * @ORM\Column(name="custmemo", type="text", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Comment",
     *              "plural_label"="Comments",
     *              "description"="Comment"
     *          }
     *      }
     * )
     */
    protected $custmemo;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="Url",
     *              "plural_label"="Urls",
     *              "description"="Url"
     *          }
     *      }
     * )
     */
    protected $url;

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
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return string
     */
    public function getContactname()
    {
        return $this->contactname;
    }

    /**
     * @param string $contactname
     */
    public function setContactname($contactname)
    {
        $this->contactname = $contactname;

        return $this;
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

        return $this;
    }



    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param string $address1
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param string $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddrstate()
    {
        return $this->addrstate;
    }

    /**
     * @param string $addrstate
     */
    public function setAddrstate($addrstate)
    {
        $this->addrstate = $addrstate;

        return $this;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone2()
    {
        return $this->phone2;
    }

    /**
     * @param string $phone2
     */
    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;

        return $this;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
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

        return $this;
    }

    /**
     * @return string
     */
    public function getCustmemo()
    {
        return $this->custmemo;
    }

    /**
     * @param string $custmemo
     */
    public function setCustmemo($custmemo)
    {
        $this->custmemo = $custmemo;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;

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
        return $this->contact;
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
