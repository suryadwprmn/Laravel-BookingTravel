<!doctype html>
<html>
<head>
    <title>Sign Up</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ asset('output.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
</head>
<body class="font-poppins text-black bg-blue">
    <section id="content" class="max-w-4xl w-full mx-auto min-h-screen flex flex-col md:flex-row items-center justify-center py-10 px-4 gap-8">
        <div class="w-full md:w-1/2 flex justify-center">
            <img src="assets/backgrounds/Asset-signup.png" class="w-full h-auto object-contain" alt="background">
        </div>
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="flex flex-col w-full md:w-1/2 bg-white p-6 gap-6 rounded-[22px] items-center shadow-lg">
            @csrf
            <div class="flex flex-col gap-2 text-center">
              <h1 class="font-semibold text-2xl">Sign Up</h1>
              <p class="text-sm text-darkGrey">Enter valid data to create your account</p>
            </div>
            <div class="flex flex-col gap-4 w-full max-w-md">
              <div class="flex flex-col gap-1 w-full">
                <p class="font-semibold">Full Name</p>
                <div class="flex items-center gap-3 p-3 border border-gray-400 rounded-xl focus-within:border-blue-600 transition-all duration-300">
                  <img src="assets/icons/user-flat-black.svg" class="w-5 h-5" alt="icon">
                  <input type="text" class="appearance-none outline-none w-full text-sm placeholder-gray-400" placeholder="Write your full name" name="name" value="{{ old('name') }}" required autofocus>
                </div>
                @error('name')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
              </div>
              <div class="flex flex-col gap-1 w-full">
                <p class="font-semibold">Phone Number</p>
                <div class="flex items-center gap-3 p-3 border border-gray-400 rounded-xl focus-within:border-blue-600 transition-all duration-300">
                  <img src="assets/icons/call.svg" class="w-5 h-5" alt="icon">
                  <input type="tel" class="appearance-none outline-none w-full text-sm placeholder-gray-400" placeholder="Your valid phone number" name="phone_number" value="{{ old('phone_number') }}" required>
                </div>
                @error('phone_number')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
              </div>
              <div class="flex flex-col gap-1 w-full">
                <p class="font-semibold">Email Address</p>
                <div class="flex items-center gap-3 p-3 border border-gray-400 rounded-xl focus-within:border-blue-600 transition-all duration-300">
                  <img src="assets/icons/sms.svg" class="w-5 h-5" alt="icon">
                  <input type="email" class="appearance-none outline-none w-full text-sm placeholder-gray-400" placeholder="Your email address" name="email" value="{{ old('email') }}" required>
                </div>
                @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
              </div>
              <div class="flex flex-col gap-1 w-full">
                <p class="font-semibold">Avatar</p>
                <div class="flex items-center gap-3 p-3 border border-gray-400 rounded-xl focus-within:border-blue-600 transition-all duration-300 overflow-hidden">
                  <img src="assets/icons/gallery-2.svg" class="w-5 h-5" alt="icon">
                  <input type="file" name="avatar" id="avatar" :value="old('avatar')" required autocomplete="avatar" class="flex items-center gap-3">
                </div>
                @error('avatar')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
              </div>
              <div class="flex flex-col gap-1 w-full">
                <p class="font-semibold">Password</p>
                <div class="flex items-center gap-3 p-3 border border-gray-400 rounded-xl focus-within:border-blue-600 transition-all duration-300">
                  <img src="assets/icons/password-lock.svg" class="w-5 h-5" alt="icon">
                  <input type="password" id="password" class="appearance-none outline-none w-full text-sm placeholder-gray-400" placeholder="Enter your valid password" name="password" required autocomplete="new-password">
                  <button type="button" class="reveal-password w-5 h-5" onclick="togglePasswordVisibility('password', this)">
                    <img src="assets/icons/password-eye.svg" class="see-password" alt="icon">
                    <img src="assets/icons/password-eye-slash.svg" class="hide-password hidden" alt="icon">
                  </button>
                </div>
                @error('password')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
              </div>
              <div class="flex flex-col gap-1 w-full">
                <p class="font-semibold">Confirm Password</p>
                <div class="flex items-center gap-3 p-3 border border-gray-400 rounded-xl focus-within:border-blue-600 transition-all duration-300">
                  <img src="assets/icons/password-lock.svg" class="w-5 h-5" alt="icon">
                  <input type="password" id="password_confirmation" class="appearance-none outline-none w-full text-sm placeholder-gray-400" placeholder="Confirm your password" name="password_confirmation" required autocomplete="new-password">
                </div>
                @error('password_confirmation')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <button type="submit" class="bg-blue p-3 w-full max-w-md rounded-lg text-center text-white font-semibold hover:bg-green-500 transition-all duration-300">Sign up</button>
            <p class="text-center text-sm text-darkGrey">Already have an account? <a href="{{ route('login') }}" class="text-blue font-semibold">Sign In</a></p>
        </form>
    </section>
    <script src="js/reveal-password.js"></script>
</body>
</html>