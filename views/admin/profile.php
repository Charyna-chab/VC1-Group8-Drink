<div class="mx-auto flex-1 h-full overflow-x-hidden overflow-y-auto">
        <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
            <div x-data="{ bgColor: 'white' }" class="rounded-lg p-6">
                <div class="shadow-lg rounded-lg p-6 mb-16 border-2 border-gray-200 dark:border-primary-darker transition duration-300"
                    :style="{ backgroundColor: bgColor }">
                    <h3 class="text-2xl font-semibold mb-4">Profile</h3>
                    <div class="flex gap-6">
                        <!-- Profile Image Section -->
                        <div class="flex flex-col items-center mt-2">
                            <div class="relative">
                                <img src="../Assets/images/uploads/<?= $user['image'] ?>" 
                                    alt="Profile Image" 
                                    class="w-64 h-80 border border-gray-300 shadow-md">
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="flex-1">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-semibold mb-3">First Name</label>
                                    <div class="w-72 border border-gray-300 p-2 rounded-md focus:ring-2 dark:border-primary-darker focus:ring-blue-500"><?= $user['FirstName']?></div>
                                        
                                </div>
                                <div>
                                    <label class="block font-semibold mb-3">Last Name</label>
                                    <div class="w-76 border border-gray-300 p-2 rounded-md focus:ring-2 dark:border-primary-darker focus:ring-blue-500"><?= $user['LastName']?></div>
                                        
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block font-semibold mb-1">Email</label>
                                <div class="flex items-center border border-gray-300 rounded-md dark:border-primary-darker">
                                    <span class="w-full p-2 focus:ring-2 focus:ring-blue-500 "><?= $user['email']?></span>
                                    <span class="px-2 text-green-600">✔️</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block font-semibold mb-1">Phone</label>
                                <div class="flex items-center border border-gray-300 rounded-md dark:border-primary-darker">
                                    <span class="w-full p-2 focus:ring-2 focus:ring-blue-500 "><?= $user['phone']?></span>  
                                    <span class="px-2 text-green-600">✔️</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block font-semibold mb-1">Role</label>
                                <div class="flex items-center border border-gray-300 rounded-md dark:border-primary-darker">
                                    <span class="w-full p-2 focus:ring-2 focus:ring-blue-500 "><?= $user['role']?></span>  
                                    <span class="px-2 text-green-600">✔️</span>
                                </div>
                            </div>
                            <button type="button" class="bg-yellow-500 text-white flex ml-auto mt-4 px-4 py-2 rounded-lg hover:opacity-90" onclick="window.location.href='/Dashboard'"> Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
