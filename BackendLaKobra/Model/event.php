<?php
namespace App\Model;

use App\Enum\State;

 class event{
     private ?int $id;
     private String $title;
     private String $date;
     private String $hour;
     private ?int $availability;
     private State $state;
     private ?int $visible_public;

      public function __construct(?int $id, string $title, string $date, string $hour, ?int $availability, State $state, ?int $visible_public) {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->hour = $hour;
        $this->availability= $availability;
        $this->State = $state;
        $this->visible_public = $visible_public;
    }

    // Getters and Setters
    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }

    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): void { $this->title = $title; }

    public function getDate(): string { return $this->date; }
    public function setDate(string $date): void { $this->date = $date; }

    public function getHour(): string { return $this->hour; }
    public function setHour(string $hour): void { $this->hour = $hour; }

    public function getAvailability(): int { return $this->availability; }
    public function setAvailability(int $availability): void { $this->availability = $availability; }

    public function getState(): State { return $this->state; }
    public function setState(State $state): void { $this->state = $state; }
    
    public function getVisible_public(): int { return $this->visible_public; }
    public function setVisible_public(int $visible_public): void { $this->visible_public = $visible_public; }
    
    public function toArray(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'date' => $this->date,
            'hour' => $this->hour,
            'availability' => $this->availability,
            'state' => $this->state->value,
            'visible_public' => $this->visible_public
        ];
    }
}
 
?>