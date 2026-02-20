--- a/resources/views/admin/setting/socialite.blade.php
+++ b/resources/views/admin/setting/socialite.blade.php
@@ -151,6 +151,14 @@
                            <li class="mb-2"><span class="fw-bold">Step 6:</span> Go to Facebook Login > Settings and add callback URL here.</li>
                            <li class="mb-2"><span class="fw-bold">Step 7:</span> Go to Settingd > Basic and copy the credentials and paste to admin panel.</li>
                    `;
+                } else if (type == 'tiktok') {
+                    var html = `
+                            <li class="mb-2"><span class="fw-bold">Step 1:</span> Go to <a href="https://developers.tiktok.com/" target="_blank">TikTok for Developers</a></li>
+                            <li class="mb-2"><span class="fw-bold">Step 2:</span> Log in and click on "Manage Apps".</li>
+                            <li class="mb-2"><span class="fw-bold">Step 3:</span> Create a new app and provide necessary details.</li>
+                            <li class="mb-2"><span class="fw-bold">Step 4:</span> Under "Products", add "Login Kit".</li>
+                            <li class="mb-2"><span class="fw-bold">Step 5:</span> In the app settings, add the Redirect URL provided in the Configure modal.</li>
+                            <li class="mb-2"><span class="fw-bold">Step 6:</span> Copy the "Client Key" (Client ID) and "Client Secret" and paste them in the admin panel.</li>
+                    `;
                 }
                $('.description').html(html);
                modal.modal('show');

