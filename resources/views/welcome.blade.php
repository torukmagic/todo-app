<?php
date_default_timezone_set('Asia/Istanbul');
use function Livewire\Volt\state;
use App\Models\Todo;

state(description: '', todos: fn() => Todo::all(), editingTodo: null, showAddForm: true);
state(plannedDate: null);

$toggleCalendar = function () {
    $this->plannedDate = !$this->plannedDate;
};

$setPlannedDate = function ($date) {
    $this->plannedDate = $date;
};

$addTodo = function () {
    $this->validate([
        'description' => 'required|min:1',
        'plannedDate' => 'nullable|date',
    ]);
    $this->todos->push(
        Todo::create([
            'description' => $this->description,
            'planned_at' => $this->plannedDate,
            'created_at' => now(),
        ]),
    );
    $this->description = '';
    $this->plannedDate = null;
    $this->showAddForm = true;
};

$deleteTodo = function ($id) {
    Todo::find($id)->delete();
    $this->todos = $this->todos->except($id);
};

$editTodo = function ($id) {
    $this->editingTodo = $id;
    $this->showAddForm = false;
    $todo = Todo::find($id);
    $this->description = $todo->description;
    $this->plannedDate = $todo->planned_at;
};

$updateTodo = function ($id) {
    $this->validate([
        'description' => 'required|min:1',
        'plannedDate' => 'nullable|date',
    ]);
    $todo = Todo::find($id);
    $todo->update([
        'description' => $this->description,
        'updated_at' => now(),
        'planned_at' => $this->plannedDate
    ]);
    $this->description = '';
    $this->plannedDate = null;
    $this->editingTodo = null;
    $this->showAddForm = true;
    $this->todos = $this->todos->map(function ($item) use ($todo) {
        if ($item->id === $todo->id) {
            return $todo;
        }
        return $item;
    });
};
?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"></meta>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Yapılacaklar</title>
</head>

<body>
    @volt
        <div class="container">
            @if ($showAddForm)
                <div class="input-area">
                    <span style="color:#0b105d;"><h1>Yapılacak iş ekle</h1></span>
                    <form wire:submit="{{ $editingTodo ? 'updateTodo(' . $editingTodo . ')' : 'addTodo' }}">
                        <input type="text" wire:model="description" placeholder="Yapılacak işi girin">

                        <label for="plannedDate" style="margin-top: 10px; font-weight: bold; display: block;">
                            Yapılacak işin planlanan zamanı:
                        </label>
                        <input type="datetime-local" id="plannedDate" wire:model="plannedDate">

                        <button type="submit" style="margin-top: 10px;">
                            {{ $editingTodo ? 'Düzenle' : 'Ekle' }}
                        </button>
                    </form>
                </div>
            @endif

            <span style="color:#0b105d;"><h1>Yapılacak işler</h1></span>
            <ul class="list-area">
                @foreach ($todos as $todo)
                    <li>
                        <div class="updated-details">
                            @if ($todo->updated_at == $todo->created_at)
                                <span style="font-family:Cursive; color:#fe6d0d;"> Yaratılan zaman: {{ optional($todo->created_at)->format('d-m-Y H:i') }}</span>
                            @else
                                <span style="font-family:Cursive; color:#fe6d0d;"> <ins>Güncellenen zaman:</ins> {{ optional($todo->updated_at)->format('d-m-Y H:i') }}</span>
                            @endif
                        </div>

                        <span style="font-family:Cursive; color:#ffb47c; border:2px solid black; border-style:dotted; padding:4px; border-color:#8386ad;">
                            Planlanan zaman: {{ \Carbon\Carbon::parse($todo->planned_at)->format('d-m-Y H:i') }}
                        </span>

                        @if ($editingTodo === $todo->id)
                            <input type="text" wire:model="description">
                            <input type="datetime-local" wire:model.fill="plannedDate" value="{{ \Carbon\Carbon::parse($todo->planned_at) }}">
                            <button type="button" wire:click="updateTodo({{ $todo->id }})">Tamamla</button>
                        @else
                            {{ $todo->description }}
                            <div class="buttons">
                                <button type="button" onmouseover="this.style.backgroundColor='#3cb40cd1'" onmouseout="this.style.backgroundColor='#f4f4f4'" wire:click="editTodo({{ $todo->id }})">Düzenle</button>
                                <button type="button" onmouseover="this.style.backgroundColor='#dd2225b0'" onmouseout="this.style.backgroundColor='#f4f4f4'" wire:click="deleteTodo({{ $todo->id }})">Sil</button>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endvolt
</body>

</html>
