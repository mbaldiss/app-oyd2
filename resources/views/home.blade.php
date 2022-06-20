@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('success'))
                <h6 class="alert alert-success">{{ session('success') }}</h6>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Orders') }}</div>
                <div class="card-body">
                    <form action="javascript: filter()">
                        <div class="input-group mb-3">
                            <select class="form-select" id="filter">
                                <option value="ALL">ALL</option>
                                <option value="GENERATED">GENERATED</option>
                                <option value="PROCEEDINGS">PROCEEDINGS</option>
                                <option value="FINALIZED">FINALIZED</option>
                            </select>
                            <input type="submit" class="btn btn-outline-secondary" type="button" value="Filter">
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Number</th>
                            <th scope="col">Description</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Value</th>
                            <th scope="col">Type</th>
                            <th scope="col">Status</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                            <th scope="col">Proceedings</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <th scope="row">{{ $order->id }}</th>
                                    <td>{{ $order->description }}</td>
                                    <td>{{ $order->amount }}</td>
                                    <td>${{ $order->value }}</td>
                                    <td>{{ $order->type }}</td>
                                    <td>{{ $order->status }}</td>
                                    
                                    @if ( $order->status == "GENERATED")
                                        <td><a href="{{ route('show', ['id' => $order->id]) }}"><button class="btn btn-warning btn-sm">📝</button></a></td>
                                        <td><a href="javascript:;" onclick="confirmationDelete('{{$order->id}}')"><button class="btn btn-danger btn-sm">🗑️</button></a></td>
                                    @else
                                        <td></td>
                                        <td></td>
                                    @endif
                                    
                                    <td>
                                        @if ( $order->status == "GENERATED")
                                            <form action="javascript: confirmationCreateFile('{{$order->id}}')">
                                                @method('PATCH')
                                                <button class="btn btn-primary btn-sm">Create</button>
                                            </form>
                                        @else
                                        @endif
                                        @if ( $order->status == "PROCEEDINGS")
                                            <form action="javascript: confirmationFinalizeFile('{{$order->id}}')">
                                                @method('PATCH')
                                                <button class="btn btn-success btn-sm">Finalize</button>
                                            </form>
                                        @else
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table> 

                    <script>
                        function confirmationDelete(id){
                            if(confirm("Are you sure you want to delete?")){
                                var url = "{{route('delete',-1)}}"
                                url= url.replace("-1",id)
                                location.href=url;
                            }
                        }
                        function confirmationCreateFile(id){
                            if(confirm("Are you sure you want to create the file?")){
                                var url = "{{route('create',-1)}}"
                                url= url.replace("-1",id)
                                location.href=url;
                            }
                        }

                        function confirmationFinalizeFile(id){
                            if(confirm("Are you sure you want to finalize the file?")){
                                var url = "{{route('finalize',-1)}}"
                                url= url.replace("-1",id)
                                location.href=url;
                            }
                        }
                    </script>

                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">{{ __('Proceedings') }}</div>
                <div class="card-body">
                    <form action="javascript: search()">
                        <div class="input-group mb-3">
                            <span class="input-group-text">000-</span>
                            <input id="search" type="number" class="form-control">
                            <input type="submit" class="btn btn-outline-secondary" type="button" value="Search">
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Number</th>
                            <th scope="col">Creator by</th>
                            <th scope="col">Created at</th>
                            <th scope="col">Number of order</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proceedings as $proceeding)
                                <tr>
                                    <th scope="row">{{ $proceeding->number }}</th>
                                    <td>{{ Auth::user()::find($proceeding->user)->name }}</td>
                                    <td>{{ $proceeding->created_at }}</td>
                                    <td>{{ $proceeding->order }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 
                    <script>
                        function search(){
                            const search = document.getElementById("search");
                            let url = "{{route('search',-1)}}"
                            url = url.replace("-1","000-" + search.value)
                            location.href=url;
                        }
                        function filter(){
                            const filter = document.getElementById("filter");
                            let url2 = "{{route('filter',-1)}}"
                            url2 = url2.replace("-1", filter.value)
                            location.href=url2;
                        }
                    </script>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
