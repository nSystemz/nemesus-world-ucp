<?php

use Illuminate\Support\Facades\Route;

//Routes

//Default
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Auth routes like login
Route::get('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'postLogin'])->name('postLogin');
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
Route::get('/twoFactor', [App\Http\Controllers\HomeController::class, 'twoFactor'])->name('twoFactor');
Route::post('/postTwoFactor', [App\Http\Controllers\HomeController::class, 'postTwoFactor'])->name('postTwoFactor');
Route::post('/postDeleteTwoFactor', [App\Http\Controllers\HomeController::class, 'postDeleteTwoFactor'])->name('postDeleteTwoFactor');
Route::post('/2fa', function () { return redirect(URL()->previous()); })->name('2fa')->middleware('2fa');
Route::get('/2fa', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/signOut', [App\Http\Controllers\HomeController::class, 'signOut'])->name('signOut');
Route::get('/forum', [App\Http\Controllers\HomeController::class, 'forum'])->name('forum');
Route::post('/postForum', [App\Http\Controllers\HomeController::class, 'postForum'])->name('postForum');
Route::post('/updateForum', [App\Http\Controllers\HomeController::class, 'updateForum'])->name('updateForum');
Route::get('/passwordForget', [App\Http\Controllers\LoginController::class, 'passwordForget'])->name('passwordForget');
Route::post('/resetPassword', [App\Http\Controllers\LoginController::class, 'resetPassword'])->name('resetPassword');

//Home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Character
Route::get('/changeCharacter/{charid}', [App\Http\Controllers\HomeController::class, 'changeCharacter'])->name('changeCharacter');
Route::get('/selectCharacter', [App\Http\Controllers\HomeController::class, 'selectCharacter'])->name('selectCharacter');
Route::post('/changeUcpStatus', [App\Http\Controllers\HomeController::class, 'changeUcpStatus'])->name('changeUcpStatus');

//Character vehicles
Route::get('/cars', [App\Http\Controllers\HomeController::class, 'getCars'])->name('cars');

//Character Bank
Route::get('/selectBank', [App\Http\Controllers\HomeController::class, 'selectBank'])->name('selectBank');
Route::post('/getBank', [App\Http\Controllers\HomeController::class, 'getBank'])->name('getBank');
Route::get('/getBank2/{id}', [App\Http\Controllers\HomeController::class, 'getBank2'])->name('getBank2');
Route::post('/transfer', [App\Http\Controllers\HomeController::class, 'transfer'])->name('transfer');

//House
Route::get('/house', [App\Http\Controllers\HomeController::class, 'getHouse'])->name('house');
Route::get('/furniture/{id}', [App\Http\Controllers\HomeController::class, 'getFurniture'])->name('getFurniture');
Route::get('/tenants/{id}', [App\Http\Controllers\HomeController::class, 'getTenants'])->name('getTenants');

//Ticket
Route::get('/createTicket', [App\Http\Controllers\HomeController::class, 'createTicket'])->name('createTicket');
Route::post('/postCreateTicket', [App\Http\Controllers\HomeController::class, 'postCreateTicket'])->name('postCreateTicket');
Route::get('/myTickets', [App\Http\Controllers\HomeController::class, 'myTickets'])->name('myTickets');
Route::get('/showTicket/{id}', [App\Http\Controllers\HomeController::class, 'showTicket'])->name('showTicket');
Route::post('/changeTicketStatus', [App\Http\Controllers\AdminController::class, 'changeTicketStatus'])->name('changeTicketStatus');
Route::post('/addUserToTicket', [App\Http\Controllers\AdminController::class, 'addUserToTicket'])->name('addUserToTicket');
Route::post('/answerTicket', [App\Http\Controllers\HomeController::class, 'answerTicket'])->name('answerTicket');
Route::post('/editTicket', [App\Http\Controllers\AdminController::class, 'editTicket'])->name('editTicket');
Route::get('/archivTicketsPlayer', [App\Http\Controllers\HomeController::class, 'archivTicketsPlayer'])->name('archivTicketsPlayer');
Route::get('/archivTickets', [App\Http\Controllers\AdminController::class, 'archivTickets'])->name('archivTickets');
Route::post('/ticketFinish', [App\Http\Controllers\HomeController::class, 'ticketFinish'])->name('ticketFinish');

//Misc
Route::get('/magischeMuschel', [App\Http\Controllers\HomeController::class, 'magischeMuschel'])->name('magischeMuschel');
Route::get('/getStatistic', [App\Http\Controllers\HomeController::class, 'getStatistic'])->name('getStatistic');
Route::get('/avatar', [App\Http\Controllers\HomeController::class, 'avatar'])->name('avatar');

//Account
Route::post('/changeName', [App\Http\Controllers\HomeController::class, 'changeName'])->name('changeName');
Route::post('/changePassword', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('changePassword');
Route::get('/advertised', [App\Http\Controllers\HomeController::class, 'getAdvertised'])->name('getAdvertised');
Route::post('/changeTheme', [App\Http\Controllers\HomeController::class, 'changeTheme'])->name('changeTheme');

//Suche
Route::get('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
Route::post('/searchUser', [App\Http\Controllers\HomeController::class, 'searchUser'])->name('searchUser');
Route::get('/search/show/{id}', [App\Http\Controllers\HomeController::class, 'searchShow'])->name('searchShow');
Route::get('/search/showAdmin/{id}', [App\Http\Controllers\AdminController::class, 'searchShowAdmin'])->name('searchShowAdmin');

//Inaktiv
Route::get('/inaktiv', [App\Http\Controllers\HomeController::class, 'getInaktiv'])->name('inaktiv');
Route::post('/setInaktiv', [App\Http\Controllers\HomeController::class, 'setInaktiv'])->name('setInaktiv');
Route::post('/unsetInaktiv', [App\Http\Controllers\HomeController::class, 'unsetInaktiv'])->name('unsetInaktiv');

//Fraktion
Route::get('/faction', [App\Http\Controllers\FactionController::class, 'getFaction'])->name('getFaction');
Route::post('/factionSwat', [App\Http\Controllers\FactionController::class, 'factionSwat'])->name('factionSwat');
Route::post('/factionUprank', [App\Http\Controllers\FactionController::class, 'factionUprank'])->name('factionUprank');
Route::post('/factionDownrank', [App\Http\Controllers\FactionController::class, 'factionDownrank'])->name('factionDownrank');
Route::post('/factionKick', [App\Http\Controllers\FactionController::class, 'factionKick'])->name('factionKick');
Route::get('/factionLog', [App\Http\Controllers\FactionController::class, 'factionLog'])->name('factionLog');
Route::get('/weaponLog', [App\Http\Controllers\FactionController::class, 'weaponLog'])->name('weaponLog');
Route::get('/govmoneyLog', [App\Http\Controllers\FactionController::class, 'govmoneyLog'])->name('govmoneyLog');
Route::get('/asservatenKammerLog', [App\Http\Controllers\FactionController::class, 'asservatenKammerLog'])->name('asservatenKammerLog');
Route::get('/factionCars', [App\Http\Controllers\FactionController::class, 'factionCars'])->name('factionCars');

//Gruppierung
Route::get('/groups', [App\Http\Controllers\GroupController::class, 'getGroups'])->name('getGroups');
Route::get('/groupCars', [App\Http\Controllers\GroupController::class, 'groupCars'])->name('groupCars');
Route::get('/groupLogs', [App\Http\Controllers\GroupController::class, 'groupLogs'])->name('groupLogs');
Route::get('/groupMoneyLog', [App\Http\Controllers\GroupController::class, 'groupMoneyLog'])->name('groupMoneyLog');
Route::post('/groupUprank', [App\Http\Controllers\GroupController::class, 'groupUprank'])->name('groupUprank');
Route::post('/groupDownrank', [App\Http\Controllers\GroupController::class, 'groupDownrank'])->name('groupDownrank');
Route::post('/groupKick', [App\Http\Controllers\GroupController::class, 'groupKick'])->name('groupKick');
Route::post('/groupMoney', [App\Http\Controllers\GroupController::class, 'groupMoney'])->name('groupMoney');
Route::get('/setGroup/{groupid}', [App\Http\Controllers\GroupController::class, 'setGroup'])->name('setGroup');
Route::post('/groupLeader', [App\Http\Controllers\GroupController::class, 'groupLeader'])->name('groupLeader');

//Admin
Route::get('/adminLogin', [App\Http\Controllers\AdminController::class, 'adminLogin'])->name('adminLogin');
Route::post('/adminLogout', [App\Http\Controllers\AdminController::class, 'adminLogout'])->name('adminLogout');
Route::post('/setAdminLogin', [App\Http\Controllers\AdminController::class, 'setAdminLogin'])->name('setAdminLogin');
Route::get('/adminDashboard', [App\Http\Controllers\AdminController::class, 'adminDashboard'])->name('adminDashboard');
Route::get('/adminLogs', [App\Http\Controllers\AdminController::class, 'adminLogs'])->name('adminLogs');
Route::get('/getAdminLogs', [App\Http\Controllers\AdminController::class, 'getAdminLogs'])->name('getAdminLogs');
Route::post('/searchAdminLogs', [App\Http\Controllers\AdminController::class, 'searchAdminLogs'])->name('searchAdminLogs');
Route::get('/adminSettings', [App\Http\Controllers\AdminController::class, 'adminSettings'])->name('adminSettings');
Route::post('/adminChangePassword', [App\Http\Controllers\AdminController::class, 'adminChangePassword'])->name('adminChangePassword');
Route::post('/adminGetPayday', [App\Http\Controllers\AdminController::class, 'adminGetPayday'])->name('adminGetPayday');
Route::post('/deleteUserakte', [App\Http\Controllers\AdminController::class, 'deleteUserakte'])->name('deleteUserakte');
Route::get('/showInaktiv', [App\Http\Controllers\AdminController::class, 'showInaktiv'])->name('showInaktiv');
Route::post('/deleteInaktiv', [App\Http\Controllers\AdminController::class, 'deleteInaktiv'])->name('deleteInaktiv');
Route::post('/adminGeneratePassword', [App\Http\Controllers\AdminController::class, 'adminGeneratePassword'])->name('adminGeneratePassword');
Route::post('/adminChangeName', [App\Http\Controllers\AdminController::class, 'adminChangeName'])->name('adminChangeName');
Route::post('/adminSetPrison', [App\Http\Controllers\AdminController::class, 'adminSetPrison'])->name('adminSetPrison');
Route::post('/adminUnsetPrison', [App\Http\Controllers\AdminController::class, 'adminUnsetPrison'])->name('adminUnsetPrison');
Route::post('/adminChangeCharName', [App\Http\Controllers\AdminController::class, 'adminChangeCharName'])->name('adminChangeCharName');
Route::post('/adminBanUser', [App\Http\Controllers\AdminController::class, 'adminBanUser'])->name('adminBanUser');
Route::post('/adminUnbanUser', [App\Http\Controllers\AdminController::class, 'adminUnbanUser'])->name('adminUnbanUser');
Route::get('/adminAccountSearch', [App\Http\Controllers\AdminController::class, 'adminAccountSearch'])->name('adminAccountSearch');
Route::post('/adminAccountSearchUser', [App\Http\Controllers\AdminController::class, 'adminAccountSearchUser'])->name('adminAccountSearchUser');
Route::post('/adminAccountSearchUserOld', [App\Http\Controllers\AdminController::class, 'adminAccountSearchUserOld'])->name('adminAccountSearchUserOld');
Route::post('/adminWarnUser', [App\Http\Controllers\AdminController::class, 'adminWarnUser'])->name('adminWarnUser');
Route::post('/adminUnwarnUser', [App\Http\Controllers\AdminController::class, 'adminUnwarnUser'])->name('adminUnwarnUser');
Route::post('/adminRemoveAdmin', [App\Http\Controllers\AdminController::class, 'adminRemoveAdmin'])->name('adminRemoveAdmin');
Route::post('/adminRemoveFaction', [App\Http\Controllers\AdminController::class, 'adminRemoveFaction'])->name('adminRemoveFaction');
Route::post('/removeTwoFactor', [App\Http\Controllers\AdminController::class, 'removeTwoFactor'])->name('removeTwoFactor');
Route::post('/adminSetNameChange', [App\Http\Controllers\AdminController::class, 'adminSetNameChange'])->name('adminSetNameChange');
Route::get('/adminNamechanges/{search}', [App\Http\Controllers\AdminController::class, 'adminNamechanges'])->name('adminNamechanges');
Route::get('/getNameChanges', [App\Http\Controllers\AdminController::class, 'getNameChanges'])->name('getNameChanges');
Route::post('/closeToDSGVO', [App\Http\Controllers\AdminController::class, 'closeToDSGVO'])->name('closeToDSGVO');
Route::post('/unCloseToDSGVO', [App\Http\Controllers\AdminController::class, 'unCloseToDSGVO'])->name('unCloseToDSGVO');
Route::post('/adminGroupKick', [App\Http\Controllers\AdminController::class, 'adminGroupKick'])->name('adminGroupKick');
Route::post('/adminGroupLeader', [App\Http\Controllers\AdminController::class, 'adminGroupLeader'])->name('adminGroupLeader');
Route::get('/selectGroups', [App\Http\Controllers\AdminController::class, 'selectGroups'])->name('selectGroups');
Route::get('/adminGroups/{groupid}', [App\Http\Controllers\AdminController::class, 'adminGroups'])->name('adminGroups');
Route::get('/adminGroupCars/{groupid}', [App\Http\Controllers\AdminController::class, 'adminGroupCars'])->name('adminGroupCars');
Route::get('/selectFactions', [App\Http\Controllers\AdminController::class, 'selectFactions'])->name('selectFactions');
Route::get('/adminFactions/{factionid}', [App\Http\Controllers\AdminController::class, 'adminFactions'])->name('adminFactions');
Route::post('/adminFactionKick', [App\Http\Controllers\AdminController::class, 'adminFactionKick'])->name('adminFactionKick');
Route::post('/adminFactionLeader', [App\Http\Controllers\AdminController::class, 'adminFactionLeader'])->name('adminFactionLeader');
Route::post('/adminFactionName', [App\Http\Controllers\AdminController::class, 'adminFactionName'])->name('adminFactionName');
Route::post('/deleteForum', [App\Http\Controllers\AdminController::class, 'deleteForum'])->name('deleteForum');
Route::get('/setLog/{logname}', [App\Http\Controllers\AdminController::class, 'setLog'])->name('setLog');
Route::get('/showItems', [App\Http\Controllers\AdminController::class, 'showItems'])->name('showItems');
Route::get('/showItemList', [App\Http\Controllers\AdminController::class, 'showItemList'])->name('showItemList');
Route::get('/adminCars/{id}', [App\Http\Controllers\AdminController::class, 'adminCars'])->name('adminCars');
Route::get('/showAnimationList', [App\Http\Controllers\AdminController::class, 'showAnimationList'])->name('showAnimationList');
Route::get('/showFurniture', [App\Http\Controllers\AdminController::class, 'showFurnitureList'])->name('showFurnitureList');
Route::get('/createChangelog', [App\Http\Controllers\AdminController::class, 'createChangelog'])->name('createChangelog');
Route::post('/postChangelog', [App\Http\Controllers\AdminController::class, 'postChangelog'])->name('postChangelog');
