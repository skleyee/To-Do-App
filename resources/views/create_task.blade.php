<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Edit Page</title>
    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
        }
    </style>
    @vite(['resources/js/create_task.js'])
</head>
<body>
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row justify-content-center">
        <form action="" class="col-md-8" method="POST">
            @csrf
            <h1 class="mb-4">Add Task</h1>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Enter title">
            </div>

            <div class="form-group">
                @if(!$categories->isEmpty())
                <label for="category">Select a category (Optional)</label>
                <select name="category_id" class="form-control" id="category">
                        <option value="new" selected>None</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Or create a new category (Optional)</small>
                @else
                     <label for="newCategory">New category (Optional)</label>
                @endif
                <input type="text" name="new_category" class="form-control" id="newCategory" placeholder="New Category">
            </div>

            <button type="submit" class="btn btn-primary">Create Task</button>
            <a href="{{route('tasks')}}" class="btn btn-secondary ml-2">Back to list</a>
        </form>
    </div>
</div>
</body>
</html>
