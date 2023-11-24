<?php

namespace App\Livewire;

use App\Models\Todo;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{

    use WithPagination;


// anotation
    #[Rule('required|min:3|max:50')]

    // for the todo name
    public $name;

    public $search;

    public $edittingTodoID;

    #[Rule('required|min:3|max:50')]

    public $edittingTodoName;


    public function create(){
    //    dd("test");
    // validate
    // create the todo
    // clear the input
    // send flash message


    // to validate only the not the search or
    // anything else that is been written below
    // the name
    $validated =  $this->validateOnly('name');

    Todo::CREATE($validated);

    //  to clear  the input bar after submitting
    $this->reset('name');


    session()->flash('success','Todo Created');

    // to return to the first page to see the new todos
    $this->resetPage();

    }

    public function delete($todoID){

        // to prevent errors especially in production
     try {

         Todo::findOrfail($todoID)->delete();

     } catch (Exception $e) {
        session()->flash('error','failed to delete todo');
        return;
     }
    }


    // public function delete(Todo $todo){
    //     $todo->delete();
    // }


    public function toggle(Todo $todo){
        // for toggling
        $todo->completed = !$todo->completed;
        $todo->save();
    }

    // public function toggle($todoID){

    //     $todo= Todo::find($todoID);
    //     $todo->completed = !$todo->completed;
    //     $todo->save();
    // }

    public function edit(Todo $todo){

        $this->edittingTodoID = $todo->id;
        $this->edittingTodoName = $todo->name;

    }

        // public function edit($todoID){

    //    $this->edittingTodoID = $todoID ;
    //    $this->edittingTodoName = Todo::find($todoID)->name;

    // }
    public function update(){

        // to validate only the new name not all of that
        $this->validateOnly('edittingTodoName');
        Todo::find($this->edittingTodoID)->update(
            [
            'name'=>$this->edittingTodoName
            ]
    );
    //   to make the input empty again
       $this->cancelEdit();
    }
    public function cancelEdit(){
        $this->reset('edittingTodoID','edittingTodoName');
    }

    public function render()
    {
        return view('livewire.todo-list',[

            // 'todos'=>Todo::latest()->paginate(5)

            // to search we can use like and we put .live in the blade to not to use
            // button click to send requests
            'todos'=>Todo::latest()->where('name','like',"%{$this->search}%")->paginate(5)
        ]);
    }
}
