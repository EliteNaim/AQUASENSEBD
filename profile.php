<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Profile Card Container -->
    <div class="flex justify-center items-center h-screen bg-gray-100">
        <div class="bg-white shadow-xl rounded-lg p-8 w-96">
            <!-- Profile Header -->
            <div class="flex flex-col items-center">
                <!-- Profile Picture -->
                <img src="https://www.w3schools.com/howto/img_avatar.png" alt="Profile Picture" class="w-24 h-24 rounded-full border-4 border-blue-500 mb-4">
                
                <!-- Name -->
                <h2 class="text-2xl font-semibold text-gray-800">John Doe</h2>
                
                <!-- Mobile Number -->
                <p class="text-gray-500 text-sm mb-2">Mobile: +1 234 567 890</p>
                
                <!-- Gender -->
                <p class="text-gray-500 text-sm mb-4">Gender: Male</p>
            </div>

            <!-- Profile Info Section -->
            <div class="mt-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Profile Info</h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-gray-600">
                        <span>Email:</span>
                        <span class="font-semibold">johndoe@example.com</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Location:</span>
                        <span class="font-semibold">New York, USA</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Joined:</span>
                        <span class="font-semibold">January 2023</span>
                    </div>
                </div>
            </div>

            <!-- Edit Button -->
            <div class="mt-8 flex justify-center">
                <a href="edit_profile.html" class="text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-md">Edit Profile</a>
            </div>
        </div>
    </div>

</body>
</html>
