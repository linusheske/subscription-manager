<?php


namespace App\Entity;


use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
#[ORM\Table(name: 'subscription')]
#[ORM\HasLifecycleCallbacks]
class Subscription
{
    /**
     * @param User $user
     * @param string $productName
     * @param DateTimeImmutable $periodStart
     * @param DateTimeImmutable $periodEnd
     * @param int $noticePeriod
     * @param string $noticePeriodType
     * @param int $periodRenewalInMonths
     * @param DateTimeImmutable|null $canceledAt
     */
    public function __construct(
        User $user,
        string $productName,
        DateTimeImmutable $periodStart,
        DateTimeImmutable $periodEnd,
        int $noticePeriod,
        string $noticePeriodType,
        int $periodRenewalInMonths,
        ?DateTimeImmutable $canceledAt
    ) {
        $this->user = $user;
        $this->productName = $productName;
        $this->periodStart = $periodStart;
        $this->periodEnd = $periodEnd;
        $this->noticePeriod = $noticePeriod;
        $this->noticePeriodType = $noticePeriodType;
        $this->periodRenewalInMonths = $periodRenewalInMonths;
        $this->canceledAt = $canceledAt;
        $this->created = new DateTimeImmutable();
        $this->updated = new DateTimeImmutable();
    }

    #[ORM\Id]
    #[ORM\Column(name: 'subscription_id', type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'subscription_user_id', referencedColumnName: 'user_id')]
    private User $user;

    #[ORM\Column(name: 'subscription_product_name', type: 'string')]
    private string $productName;

    #[ORM\Column(name: 'subscription_period_start', type: 'datetime_immutable')]
    private DateTimeImmutable $periodStart;

    #[ORM\Column(name: 'subscription_period_end', type: 'datetime_immutable')]
    private DateTimeImmutable $periodEnd;

    #[ORM\Column(name: 'subscription_notice_period', type: 'integer')]
    private int $noticePeriod;

    #[ORM\Column(name: 'subscription_notice_period_type', type: 'string')]
    private string $noticePeriodType;

    #[ORM\Column(name: 'subscription_period_renewal_in_months', type: 'integer')]
    private int $periodRenewalInMonths;

    #[ORM\Column(name: 'subscription_canceled_at', type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $canceledAt;

    #[ORM\Column(name: 'subscription_created', type: 'datetime_immutable')]
    private DateTimeImmutable $created;

    #[ORM\Column(name: 'subscription_updated', type: 'datetime_immutable')]
    private DateTimeImmutable $updated;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): void
    {
        $this->productName = $productName;
    }

    public function getPeriodStart(): DateTimeImmutable
    {
        return $this->periodStart;
    }

    public function setPeriodStart(DateTimeImmutable $periodStart): void
    {
        $this->periodStart = $periodStart;
    }

    public function getPeriodEnd(): DateTimeImmutable
    {
        return $this->periodEnd;
    }

    public function setPeriodEnd(DateTimeImmutable $periodEnd): void
    {
        $this->periodEnd = $periodEnd;
    }

    public function getNoticePeriod(): int
    {
        return $this->noticePeriod;
    }

    public function setNoticePeriod(int $noticePeriod): void
    {
        $this->noticePeriod = $noticePeriod;
    }

    public function getNoticePeriodType(): string
    {
        return $this->noticePeriodType;
    }

    public function setNoticePeriodType(string $noticePeriodType): void
    {
        $this->noticePeriodType = $noticePeriodType;
    }

    public function getPeriodRenewalInMonths(): int
    {
        return $this->periodRenewalInMonths;
    }

    public function setPeriodRenewalInMonths(int $periodRenewalInMonths): void
    {
        $this->periodRenewalInMonths = $periodRenewalInMonths;
    }

    public function getCanceledAt(): DateTimeImmutable
    {
        return $this->canceledAt;
    }

    public function setCanceledAt(DateTimeImmutable $canceledAt): void
    {
        $this->canceledAt = $canceledAt;
    }

    #[ORM\PrePersist]
    public function setCreated(): void
    {
        $this->created = new DateTimeImmutable();
        $this->setUpdated();
    }

    #[ORM\PreUpdate]
    public function setUpdated(): void
    {
        $this->updated = new DateTimeImmutable();
    }

    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }

    public function getUpdated(): DateTimeImmutable
    {
        return $this->updated;
    }
}