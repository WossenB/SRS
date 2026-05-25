<x-guest-layout>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 bg-slate-50">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm text-center">
            <div class="mx-auto h-12 w-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white text-2xl font-black shadow-xl shadow-indigo-200">B</div>
            <h2 class="mt-10 text-center text-2xl font-black leading-9 tracking-tight text-gray-900">Sign in to Birrama HRMS</h2>
            <p class="text-sm text-gray-500 font-medium mt-2">Enterprise Human Resource Management System</p>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-black uppercase tracking-widest text-gray-400">Work Email</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-2xl border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition">
                    </div>
                    @error('email') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-xs font-black uppercase tracking-widest text-gray-400">Password</label>
                        <div class="text-xs font-bold">
                            <a href="#" class="text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-2xl border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition">
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-2xl bg-indigo-600 px-3 py-4 text-sm font-black leading-6 text-white shadow-xl shadow-indigo-100 hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition">
                        Enter HRMS Dashboard
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">
                Birrama Digital Commerce PLC &copy; 2025
            </p>
        </div>
    </div>
</x-guest-layout>
