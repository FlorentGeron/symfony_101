<?php

namespace App\Entity;

use App\Repository\ChannelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChannelRepository::class)]
class Channel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Title;

    #[ORM\OneToMany(mappedBy: 'Channel_id', targetEntity: Message::class, orphanRemoval: true)]
    private $messages;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'channels')]
    private $Invited;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->Invited = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function __toString()
    {
      return $this->Title;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setChannelId($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getChannelId() === $this) {
                $message->setChannelId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getInvited(): Collection
    {
        return $this->Invited;
    }

    public function addInvited(User $invited): self
    {
        if (!$this->Invited->contains($invited)) {
            $this->Invited[] = $invited;
        }

        return $this;
    }

    public function removeInvited(User $invited): self
    {
        $this->Invited->removeElement($invited);

        return $this;
    }
}
