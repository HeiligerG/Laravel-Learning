<x-layout>
    <section class="flex flex-col md:flex-row gap-4">
        <div class="bg-white p-8 rounded-lg shadow-md w-full">
            <h3 class="text-3xl text-center font-bold mb-4">
                Profile Info
            </h3>

            @if($user->avatar)
                <div class="mt-2 flex justify-center">
                    <img src="{{asset('storage/' . $user->avatar)}}" alt="{{$user->name}}" class="w-32 h-32 object-cover rounded-full">
                </div>
            @endif

            <form method="POST" action="{{route('profile.update')}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <x-inputs.text id="name" name="name" label="Name" value="{{$user->name}}" />
                <x-inputs.text id="email" name="email" label="Email address" type="email" value="{{$user->email}}" />

                <x-inputs.file id="avatar" name="avatar" label=" Upload Avatar" />

                <button type="submit" class="w-full bg-green-500 Hover:bg-green-600 text-white px-4 py-2 border-rounded focus:outline-none">
                    Save
                </button>

            </form>
        </div>
    <div class="bg-white p-8 rounded-lg shadow-md w-full">
        <h3 class="text-3xl text-center font-bold mb-4">
            My Job Listings
        </h3>
        @forelse($jobs as $job)
            <div class="flex justify-between items-center border-b-2 border-grey-200 py-2">
                <div>
                <h3 class="text-xl font-semibold">{{$job->title}}</h3>
                <p class="text-gray-700">{{$job->job_type}}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{route('jobs.edit', $job->id)}}" class="bg-blue-500 text-white px-4 py-2 rounded text-sm">Edit</a>
                    <form method="POST" action="{{route('jobs.destroy', $job->id)}}?from=dashboard" onsubmit="return confirm('Are you sure to delete this Job?')">
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded text-sm"
                        >
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="mt-4 bg-gray-50 rounded p-4">
                    <h4 class="mt-4 text-lg font-semibold mb-2">Applicants</h4>
                    @forelse($job->applicants as $applicant)
                        <div class="py-2">
                            <p class="text-grey-800">
                                <strong>Name: </strong> {{$applicant->full_name}}
                            </p>
                            <p class="text-grey-800">
                                <strong>Phone: </strong> {{$applicant->contact_phone}}
                            </p>
                            <p class="text-grey-800">
                                <strong>Email: </strong> {{$applicant->contact_email}}
                            </p>
                            <p class="text-grey-800">
                                <strong>Message: </strong> {{$applicant->message}}
                            </p>
                            <p class="text-grey-800 my-4 mt-2">
                                <a href="{{asset('storage/' . $applicant->resume_path)}}}" class="text-blue-500 hover:underline text-sm" download>
                                    <i class="fas fa-download"></i> Download Resume
                                </a>
                            </p>
                            <form method="POST" action="{{route('applicant.destroy', $applicant->id)}}" onsubmit="return confirm('Are you sure to delete this Applicant?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="text-red-500 hover:text-red-600 text-sm"
                                >
                                    <i class="fas fa-trash-alt"></i>
                                    Delete Applicant
                                </button>
                            </form>
                        </div>
            </div>
                    @empty
                        <p class="text-grey-700">No Applicants on this Job</p>
                    @endforelse
                    @empty
                    <p class="text-gray-700">
                        You have no Job listings
                    </p>
                        @endforelse
            </section>
    <x-bottom-banner />
</x-layout>
