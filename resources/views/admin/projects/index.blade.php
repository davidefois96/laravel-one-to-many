

@php
use App\Functions\Helper as Helper;
@endphp

@extends('layouts.admin')



@section('content')

    <div class="p-5">



        <h1 class="text-center">Progetti</h1>

        @if (session('cancel'))

            <div class="alert alert-success mb-3 " role="alert">
            {{session('cancel')}}
            </div>

        @endif

        <table class="table my-5">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Type</th>
                <th scope="col">Date</th>
                <th scope="col">Image</th>
                <th scope="col">Interagisci</th>
            </tr>
            </thead>
            <tbody>
                @forelse ($projects as $project )

                <tr>
                    <th scope="row">{{$project->id}}</th>
                    <td>{{$project->name}}</td>
                    <td>{{$project->type->name}}</td>
                    <td>{{Helper::formatDate($project->update_at)}}</td>
                    <td><img class="" src="{{asset('storage/' . $project->image)}}" alt="{{$project->name}}" onerror="this.src=`/img/placeholder.png`"></td>
                    <td >
                        <a class="btn btn-success me-2" href="{{route('admin.projects.show',$project)}}"><i class="fa-solid fa-eye"></i></a>

                        <a class="btn btn-warning me-2" href="{{route('admin.projects.edit',$project)}}" ><i class="fa-solid fa-pencil"></i></a>


                        @include('admin.partials.deleteForm', [
                            'route'=>route('admin.projects.destroy',$project),
                            'message'=> 'sei sicuro di voler eliminare '. $project->name . '?'

                        ])





                    </td>
                </tr>

                @empty

                Nessun risultato

                @endforelse


            </tbody>
        </table>

        {{$projects->links('pagination::bootstrap-5')}}


    </div>




@endsection

