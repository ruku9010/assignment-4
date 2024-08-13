@extends('layout')  

@section('content')  
<h1>Contact List</h1>  
<a href="{{ route('contacts.create') }}">Create New Contact</a>  

<form method="GET" action="{{ route('contacts.index') }}">  
    <input type="text" name="search" value="{{ old('search', $search) }}" placeholder="Search by name or email">  
    <select name="sort">  
        <option value="name" {{ $sortBy == 'name' ? 'selected' : '' }}>Sort by Name</option>  
        <option value="created_at" {{ $sortBy == 'created_at' ? 'selected' : '' }}>Sort by Date</option>  
    </select>  
    <button type="submit">Search</button>  
</form>  

@if(session('success'))  
    <div>{{ session('success') }}</div>  
@endif  

<table>  
    <tr>  
        <th>Name</th>  
        <th>Email</th>  
        <th>Actions</th>  
    </tr>  
    @foreach($contacts as $contact)  
    <tr>  
        <td>{{ $contact->name }}</td>  
        <td>{{ $contact->email }}</td>  
        <td>  
            <a href="{{ route('contacts.show', $contact->id) }}">View</a>  
            <a href="{{ route('contacts.edit', $contact->id) }}">Edit</a>  
            <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display:inline;">  
                @csrf  
                @method('DELETE')  
                <button type="submit">Delete</button>  
            </form>  
        </td>  
    </tr>  
    @endforeach  
</table>  

{{ $contacts->links() }} 
@endsection

