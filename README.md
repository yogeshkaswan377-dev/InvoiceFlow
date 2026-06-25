
```
gst-invoice-saas
├─ .editorconfig
├─ api-routes.json
├─ app
│  ├─ DTOs
│  │  ├─ ClientData.php
│  │  ├─ CompanyData.php
│  │  ├─ CompanySettingsData.php
│  │  ├─ InvoiceData.php
│  │  ├─ InvoiceItemData.php
│  │  ├─ InvoiceTotals.php
│  │  ├─ TaxBreakdown.php
│  │  └─ UserData.php
│  ├─ Helpers
│  │  └─ NumberToWords.php
│  ├─ Http
│  │  ├─ Controllers
│  │  │  ├─ Api
│  │  │  │  ├─ ClientController.php
│  │  │  │  └─ V1
│  │  │  │     ├─ AuthController.php
│  │  │  │     ├─ ClientController.php
│  │  │  │     ├─ CompanyController.php
│  │  │  │     ├─ DashboardController.php
│  │  │  │     ├─ GSTInvoiceController.php
│  │  │  │     ├─ ProductController.php
│  │  │  │     ├─ ProformaController.php
│  │  │  │     ├─ ReportController.php
│  │  │  │     └─ SettingController.php
│  │  │  ├─ Auth
│  │  │  │  ├─ AuthenticatedSessionController.php
│  │  │  │  ├─ ConfirmablePasswordController.php
│  │  │  │  ├─ EmailVerificationNotificationController.php
│  │  │  │  ├─ EmailVerificationPromptController.php
│  │  │  │  ├─ NewPasswordController.php
│  │  │  │  ├─ PasswordController.php
│  │  │  │  ├─ PasswordResetLinkController.php
│  │  │  │  ├─ RegisteredUserController.php
│  │  │  │  └─ VerifyEmailController.php
│  │  │  ├─ ClientController.php
│  │  │  ├─ CompanyController.php
│  │  │  ├─ CompanySettingsController.php
│  │  │  ├─ Controller.php
│  │  │  ├─ DashboardController.php
│  │  │  ├─ GSTInvoiceController.php
│  │  │  ├─ ProductController.php
│  │  │  ├─ ProfileController.php
│  │  │  ├─ ProformaController.php
│  │  │  ├─ ReportController.php
│  │  │  ├─ SettingController.php
│  │  │  ├─ StaffController.php
│  │  │  └─ SuperAdmin
│  │  │     ├─ AnalyticsController.php
│  │  │     ├─ AuditController.php
│  │  │     ├─ CompanyController.php
│  │  │     ├─ DashboardController.php
│  │  │     ├─ InvoiceController.php
│  │  │     ├─ LogController.php
│  │  │     ├─ ProfileController.php
│  │  │     ├─ ProformaController.php
│  │  │     ├─ SettingController.php
│  │  │     ├─ SubscriptionController.php
│  │  │     └─ UserController.php
│  │  ├─ Middleware
│  │  │  ├─ CheckPermission.php
│  │  │  ├─ CompanySelected.php
│  │  │  ├─ EnsureCompanySelected.php
│  │  │  ├─ EnsureCompanySelectedApi.php
│  │  │  └─ SuperAdminMiddleware.php
│  │  ├─ Requests
│  │  │  ├─ Auth
│  │  │  │  └─ LoginRequest.php
│  │  │  ├─ ProfileUpdateRequest.php
│  │  │  ├─ StoreClientRequest.php
│  │  │  ├─ StoreCompanyRequest.php
│  │  │  ├─ StoreProformaRequest.php
│  │  │  ├─ UpdateClientRequest.php
│  │  │  ├─ UpdateCompanyRequest.php
│  │  │  └─ UpdateProformaRequest.php
│  │  └─ Resources
│  │     ├─ ClientResource.php
│  │     ├─ CompanyResource.php
│  │     ├─ InvoiceItemResource.php
│  │     ├─ InvoiceResource.php
│  │     ├─ PaginatedResourceTrait.php
│  │     ├─ ProductResource.php
│  │     └─ TaxBreakdownResource.php
│  ├─ Mail
│  │  ├─ InvoiceMail.php
│  │  ├─ OverdueReminderMail.php
│  │  └─ ProformaMail.php
│  ├─ Models
│  │  ├─ Client.php
│  │  ├─ Company.php
│  │  ├─ CompanyInvite.php
│  │  ├─ GstRate.php
│  │  ├─ Invoice.php
│  │  ├─ InvoiceItem.php
│  │  ├─ InvoicePayment.php
│  │  ├─ InvoiceSequence.php
│  │  ├─ InvoiceTemplate.php
│  │  ├─ Product.php
│  │  ├─ Role.php
│  │  ├─ Setting.php
│  │  ├─ State.php
│  │  └─ User.php
│  ├─ Policies
│  │  ├─ ClientPolicy.php
│  │  ├─ CompanyPolicy.php
│  │  └─ InvoicePolicy.php
│  ├─ Providers
│  │  ├─ AppServiceProvider.php
│  │  ├─ AuthServiceProvider.php
│  │  └─ RepositoryServiceProvider.php
│  ├─ Repositories
│  │  ├─ BaseRepository.php
│  │  ├─ ClientRepository.php
│  │  ├─ CompanyRepository.php
│  │  ├─ Contracts
│  │  │  ├─ BaseRepositoryInterface.php
│  │  │  ├─ ClientRepositoryInterface.php
│  │  │  ├─ CompanyRepositoryInterface.php
│  │  │  └─ InvoiceRepositoryInterface.php
│  │  └─ InvoiceRepository.php
│  ├─ Services
│  │  ├─ Client
│  │  │  └─ ClientService.php
│  │  ├─ Company
│  │  │  └─ CompanySettingsService.php
│  │  ├─ GST
│  │  │  ├─ GSTCalculationService.php
│  │  │  ├─ GSTValidationService.php
│  │  │  ├─ PlaceOfSupplyService.php
│  │  │  └─ TaxBreakdownService.php
│  │  ├─ Invoice
│  │  │  ├─ GSTInvoiceService.php
│  │  │  ├─ InvoiceService.php
│  │  │  └─ InvoiceStateManager.php
│  │  └─ NumberGenerator
│  │     └─ InvoiceNumberGenerator.php
│  └─ View
│     └─ Components
│        ├─ AppLayout.php
│        └─ GuestLayout.php
├─ artisan
├─ bootstrap
│  ├─ app.php
│  ├─ cache
│  │  ├─ packages.php
│  │  └─ services.php
│  └─ providers.php
├─ composer.json
├─ composer.lock
├─ config
│  ├─ app.php
│  ├─ auth.php
│  ├─ cache.php
│  ├─ cors.php
│  ├─ database.php
│  ├─ dompdf.php
│  ├─ filesystems.php
│  ├─ indian_states.php
│  ├─ logging.php
│  ├─ mail.php
│  ├─ permission.php
│  ├─ queue.php
│  ├─ sanctum.php
│  ├─ services.php
│  └─ session.php
├─ database
│  ├─ database.sqlite
│  ├─ factories
│  │  ├─ ClientFactory.php
│  │  ├─ CompanyFactory.php
│  │  ├─ InvoiceFactory.php
│  │  └─ UserFactory.php
│  ├─ migrations
│  │  ├─ 0001_01_01_000000_create_users_table.php
│  │  ├─ 0001_01_01_000001_create_cache_table.php
│  │  ├─ 0001_01_01_000002_create_jobs_table.php
│  │  ├─ 2026_05_17_153157_create_personal_access_tokens_table.php
│  │  ├─ 2026_05_17_153218_create_permission_tables.php
│  │  ├─ 2026_05_17_154057_create_companies_table.php.php
│  │  ├─ 2026_05_17_154226_add_company_fields_to_users_table.php.php
│  │  ├─ 2026_05_17_154313_create_role_user_table.php.php
│  │  ├─ 2026_05_17_163016_add_display_name_and_description_to_roles_table.php
│  │  ├─ 2026_05_18_121727_create_clients_table.php
│  │  ├─ 2026_05_18_121926_add_company_settings_fields.php
│  │  ├─ 2026_05_18_122014_create_states_table.php
│  │  ├─ 2026_05_18_152650_create_settings_table.php
│  │  ├─ 2026_05_19_153337_add_state_and_status_to_clients_table.php
│  │  ├─ 2026_05_20_154547_add_role_to_users_table.php
│  │  ├─ 2026_05_20_162144_add_company_name_to_companies_table.php
│  │  ├─ 2026_05_28_142500_add_export_to_client_type_enum.php
│  │  ├─ 2026_06_10_173619_remove_role_column_from_users_table.php
│  │  ├─ 2026_06_11_120344_create_invoices_table.php
│  │  ├─ 2026_06_11_120423_create_invoice_items_table.php
│  │  ├─ 2026_06_11_120603_create_invoice_payments_table.php
│  │  ├─ 2026_06_11_120631_create_invoice_templates_table.php
│  │  ├─ 2026_06_11_120708_create_invoice_sequences_table.php
│  │  ├─ 2026_06_11_120739_create_gst_rates_table.php
│  │  ├─ 2026_06_11_140611_add_soft_deletes_to_gst_rates_table.php
│  │  ├─ 2026_06_15_150842_create_products_table.php
│  │  ├─ 2026_06_17_132617_add_theme_to_companies_table.php
│  │  └─ 2026_06_18_121220_create_company_invites_table.php
│  └─ seeders
│     ├─ CompanySeeder.php
│     ├─ DatabaseSeeder.php
│     ├─ GstRateSeeder.php
│     ├─ RoleSeeder.php
│     └─ SampleDataSeeder.php
├─ get()
├─ package-lock.json
├─ package.json
├─ phpunit.xml
├─ postcss.config.js
├─ postman-collection.json
├─ public
│  ├─ .htaccess
│  ├─ favicon.ico
│  ├─ index.php
│  └─ robots.txt
├─ README.md
├─ resources
│  ├─ css
│  │  └─ app.css
│  ├─ js
│  │  ├─ app.js
│  │  ├─ bootstrap.js
│  │  └─ components
│  │     ├─ bank-details.js
│  │     ├─ client-search.js
│  │     ├─ file-upload.js
│  │     ├─ gst-rates-manager.js
│  │     ├─ gstin-manager.js
│  │     └─ state-search.js
│  └─ views
│     ├─ auth
│     │  ├─ confirm-password.blade.php
│     │  ├─ forgot-password.blade.php
│     │  ├─ invite-register.blade.php
│     │  ├─ login.blade.php
│     │  ├─ register.blade.php
│     │  ├─ reset-password.blade.php
│     │  └─ verify-email.blade.php
│     ├─ clients
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  ├─ index.blade.php
│     │  └─ show.blade.php
│     ├─ company
│     │  ├─ create.blade.php
│     │  ├─ settings.blade.php
│     │  └─ switch.blade.php
│     ├─ components
│     │  ├─ application-logo.blade.php
│     │  ├─ auth-session-status.blade.php
│     │  ├─ danger-button.blade.php
│     │  ├─ dropdown-link.blade.php
│     │  ├─ dropdown.blade.php
│     │  ├─ input-error.blade.php
│     │  ├─ input-label.blade.php
│     │  ├─ modal.blade.php
│     │  ├─ nav-link.blade.php
│     │  ├─ primary-button.blade.php
│     │  ├─ responsive-nav-link.blade.php
│     │  ├─ secondary-button.blade.php
│     │  ├─ super-admin
│     │  │  └─ stats-card.blade.php
│     │  ├─ text-input.blade.php
│     │  └─ toast.blade.php
│     ├─ dashboard.blade.php
│     ├─ emails
│     │  ├─ invoice.blade.php
│     │  ├─ overdue-reminder.blade.php
│     │  └─ proforma.blade.php
│     ├─ gst-invoices
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  ├─ index.blade.php
│     │  ├─ pdf.blade.php
│     │  └─ show.blade.php
│     ├─ layouts
│     │  ├─ app.blade.php
│     │  ├─ guest.blade.php
│     │  ├─ navigation.blade.php
│     │  └─ super-admin.blade.php
│     ├─ products
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  └─ index.blade.php
│     ├─ profile
│     │  ├─ edit.blade.php
│     │  └─ partials
│     │     ├─ delete-user-form.blade.php
│     │     ├─ update-password-form.blade.php
│     │     └─ update-profile-information-form.blade.php
│     ├─ proformas
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  ├─ index.blade.php
│     │  ├─ pdf.blade.php
│     │  └─ show.blade.php
│     ├─ reports
│     │  ├─ gstr1.blade.php
│     │  └─ outstanding.blade.php
│     ├─ settings
│     │  ├─ index.blade.php
│     │  └─ partials
│     │     ├─ basic-info.blade.php
│     │     └─ gst-settings.blade.php
│     ├─ staff
│     │  └─ invite.blade.php
│     ├─ super-admin
│     │  ├─ analytics
│     │  │  └─ index.blade.php
│     │  ├─ analytics.blade.php
│     │  ├─ audit
│     │  │  └─ index.blade.php
│     │  ├─ companies
│     │  │  ├─ index.blade.php
│     │  │  ├─ invoices.blade.php
│     │  │  ├─ show.blade.php
│     │  │  └─ users.blade.php
│     │  ├─ companies.blade.php
│     │  ├─ dashboard.blade.php
│     │  ├─ invoices
│     │  │  ├─ index.blade.php
│     │  │  └─ show.blade.php
│     │  ├─ logs
│     │  │  └─ index.blade.php
│     │  ├─ logs.blade.php
│     │  ├─ partials
│     │  │  ├─ sidebar.blade.php
│     │  │  └─ topbar.blade.php
│     │  ├─ profile
│     │  │  └─ index.blade.php
│     │  ├─ proformas
│     │  │  ├─ index.blade.php
│     │  │  └─ show.blade.php
│     │  ├─ settings
│     │  │  └─ index.blade.php
│     │  ├─ subscriptions
│     │  │  └─ index.blade.php
│     │  └─ users
│     │     ├─ index.blade.php
│     │     └─ show.blade.php
│     └─ welcome.blade.php
├─ routes
│  ├─ api.php
│  ├─ auth.php
│  ├─ console.php
│  └─ web.php
├─ storage
│  ├─ app
│  │  ├─ private
│  │  └─ public
│  │     ├─ logos
│  │     │  └─ TlPByHnMCkC4Tv2Fx9h8tmrOhuRDbVn0F6vp7CdC.jpg
│  │     └─ signatures
│  │        └─ dbAeGQCsSx5LyFdxO91IA2LdadM74RppphqKEoKA.png
│  ├─ fonts
│  │  ├─ DejaVuSans-Bold.ufm.json
│  │  ├─ DejaVuSans-BoldOblique.ufm.json
│  │  ├─ DejaVuSans-Oblique.ufm.json
│  │  ├─ DejaVuSans.ufm.json
│  │  ├─ Helvetica-Bold.afm.json
│  │  ├─ Helvetica-BoldOblique.afm.json
│  │  ├─ Helvetica.afm.json
│  │  └─ NotoSansDevanagari-Regular.ttf
│  ├─ framework
│  │  ├─ cache
│  │  │  └─ data
│  │  ├─ sessions
│  │  ├─ testing
│  │  │  └─ disks
│  │  │     └─ public
│  │  │        └─ signatures
│  │  │           └─ p8HseB0wvMIF9L47FTmgXXSY95DvdR4cTP101yFT.png
│  │  └─ views
│  │     ├─ 04b50fe689347d827e794405f6555e85.php
│  │     ├─ 04baced3750385b0949bfba2aa325f5d.php
│  │     ├─ 09e5de51f29585e29dc3ca7151bd54e7.php
│  │     ├─ 0a3f531b346b5f3f350ded4a1c7dea77.php
│  │     ├─ 0cbfdf0188a69c61c75fe1330d573c4c.php
│  │     ├─ 10fa21949f30f62c73e6145e1877aec9.php
│  │     ├─ 13662c9be3d5162e08e7aea69b3d8cd0.php
│  │     ├─ 14c3e02cd01938894bd26e901eef15d2.php
│  │     ├─ 14d8516d20934b5626e669c3ab17d222.php
│  │     ├─ 18056b7322426d18fe590b6c4844f859.php
│  │     ├─ 1933d9972192cb76ae923dc98b1ec9d7.php
│  │     ├─ 19951209ce9e0735e5e793dcd81192b8.php
│  │     ├─ 1fd464682ca01d64f40dbe7a14ee69e1.php
│  │     ├─ 22dd8b237f3a5b0e839efd70a796b759.php
│  │     ├─ 232374c83cef5d297429e20ea415dad1.php
│  │     ├─ 2877b94d28b4c5ee9601559a3175df96.php
│  │     ├─ 2b9ac580bb7311f319c0512319b05373.php
│  │     ├─ 31095cdb58e780ffafcd362bfb394ffc.php
│  │     ├─ 343ecefa0cd7aa0cebbe696d82b47b3f.php
│  │     ├─ 3569438790576db9dc7bec1ecd55d296.php
│  │     ├─ 3b4853f13019dd93825d9505d7ed34f4.php
│  │     ├─ 3c0d17fdf5f39d3ae849875116c45979.php
│  │     ├─ 3f9f5d01867190325938511b9fa09826.php
│  │     ├─ 42ad17f34d7227ad1d10aefb793cd6e1.php
│  │     ├─ 44b28a600d5b9b19a076e439ded37c10.php
│  │     ├─ 46c2037839b9f8f968f78f64dc250e28.php
│  │     ├─ 4a5dcbfe707b3100c3ec4139670230ba.php
│  │     ├─ 507c2b7cf9a555020e354b3bd83cd31c.php
│  │     ├─ 5310a354f8b200adb1a08d2db7434177.php
│  │     ├─ 5aac5425270e42bd5b7d21a2af449693.php
│  │     ├─ 626ba4c47d46a26a4fed83f3fa6dd149.php
│  │     ├─ 6a42de06ba36c7d57fd69166d79090e4.php
│  │     ├─ 745c54372fa30a8afe09bc37c68e5a3d.php
│  │     ├─ 7bd684a061b8b0ecad45cf57dfc80b50.php
│  │     ├─ 7cf4dbf5373761a50a0fa0f7713535fb.php
│  │     ├─ 7eb452be8725c01909fd8e62d433c181.php
│  │     ├─ 8770fd0e59fd0a7b5aa8e707073a0d7a.php
│  │     ├─ 878cd0556b0683935c94ce0d6b19e73a.php
│  │     ├─ 8c6e76c9493db24b2f3664b36c0799d9.php
│  │     ├─ 8da3afd36b3922d5dade322846dd8d8a.php
│  │     ├─ 900455e29bd10728ffbb1cc871d5d9da.php
│  │     ├─ 910e23686f167b9ecc882d0ff626d63a.php
│  │     ├─ 9115bd4ce6c845b90689735038b4614b.php
│  │     ├─ 91649b78946c5862db11e736991dceff.php
│  │     ├─ 9935223dff4040a53f9f242d0aa5a714.php
│  │     ├─ a2942797c49d4656c0583a152ef838ad.php
│  │     ├─ a3fb0d395b11d2ac3fc2360e3161ff8c.php
│  │     ├─ a50992f80f69b74d2dfd9a9c8e9db20d.php
│  │     ├─ a6084687ac3160e4efa0b439ec141b37.php
│  │     ├─ a918bdfa73b0764e9d1d5375503c2996.php
│  │     ├─ a96c308a52e3cb19105f8676ade409be.php
│  │     ├─ a96ebae7bba2deb72d172e1e40f27b35.php
│  │     ├─ abe58729f2a016fbfd3e22726c7e39c9.php
│  │     ├─ b0e4a885e750c80db11b8233d9d008cb.php
│  │     ├─ b41ef81ee0e2866d432936894aae9f57.php
│  │     ├─ b55f452558e8508cbd8a3ce0bde25000.php
│  │     ├─ bebf90ea8e107cbb2e38c16fed712e43.php
│  │     ├─ becec0315eca9a41a5c7b41eee388c90.php
│  │     ├─ c4399468fdfcecf11d1f6abb52edccfd.php
│  │     ├─ c63c731542a54925f6887a34a8b694dc.php
│  │     ├─ c68e0f536625079a8c1414f9e363621c.php
│  │     ├─ cf6e822fb61310d93c89a2901713049d.php
│  │     ├─ d08de4aa5566fdb7708944033d2dfa2a.php
│  │     ├─ d30ef3f91d9502416001bd794bb73c77.php
│  │     ├─ d45335ca457511830e90801658a69676.php
│  │     ├─ d45aff8f515aa79e457afad960b988c7.php
│  │     ├─ d79619ade1cf44e7665331e80cbd2091.php
│  │     ├─ d9f347a3d679b7316759ff23f1b23f9b.php
│  │     ├─ e08ac5d0623b4946daa9f2f9d7ed101a.php
│  │     ├─ e415b9cc5eb28d76a891527ec60909de.php
│  │     ├─ e46fbab7c07dd688a1d7d39211e850d0.php
│  │     ├─ eda1053e4e65a0aea1a6d7f47433c0f1.php
│  │     ├─ f1113ad8fa2e991b45c60e02ba1e6fc7.php
│  │     ├─ f28bee1e5b0e9cd6aea88992cd6c4f4f.php
│  │     ├─ f33bdf7a3636bee76d379d1b083236b1.php
│  │     └─ fb43969879f5d5e0571733a89adb6a2d.php
│  └─ logs
├─ tailwind.config.js
├─ tests
│  ├─ Feature
│  │  ├─ Api
│  │  │  ├─ ApiAuthenticationTest.php
│  │  │  ├─ ApiClientTest.php
│  │  │  └─ ApiRateLimitTest.php
│  │  ├─ Auth
│  │  │  ├─ AuthenticationTest.php
│  │  │  ├─ EmailVerificationTest.php
│  │  │  ├─ PasswordConfirmationTest.php
│  │  │  ├─ PasswordResetTest.php
│  │  │  ├─ PasswordUpdateTest.php
│  │  │  └─ RegistrationTest.php
│  │  ├─ ClientManagementTest.php
│  │  ├─ CompanySettingsTest.php
│  │  ├─ CompanyTest.php
│  │  ├─ ExampleTest.php
│  │  ├─ GSTInvoiceTest.php
│  │  ├─ InvoiceManagementTest.php
│  │  ├─ ProfileTest.php
│  │  └─ ProformaInvoiceTest.php
│  ├─ TestCase.php
│  └─ Unit
│     ├─ ExampleTest.php
│     ├─ GSTCalculationServiceTest.php
│     ├─ GSTValidationServiceTest.php
│     └─ PlaceOfSupplyServiceTest.php
└─ vite.config.js

```