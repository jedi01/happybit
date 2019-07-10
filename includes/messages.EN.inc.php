<?
if(!defined('INCLUDED')) exit("Access denied");
// // CHARSET ENCODING
// // Change the charset according to the language used in this file.
// // UTF-8 should work with almost any language
$CHARSET = "ISO 8859-1";
// // DOCUMENT DIRECTION
// // Change the $DOCDIR variable below according to the document direction neeeded
// // by the language you are using.
// // Possible values are:
// // 	- ltr (default) - means left-to-right document (almost any language)
// // 	- rtl - means right-to-left document (i.e. arabic, hebrew, ect).
$DOCDIR = "ltr";
// // Error messages and user interface messages are below. Translate them taking care of leaving
// // The PHP and HTML tags unchanged.
// // Error messages =============================================================
$ERR = ""; // leave this line as is
$ERR_000 = ""; // leave this line as is
$ERR_001 = "Database access error. Please contact the site administrator.";
$ERR_002 = "Name missing";
$ERR_003 = "Username missing";
$ERR_004 = "Password missing";
$ERR_005 = "Please repeat your password";
$ERR_006 = "Passwords do not match";
$ERR_007 = "E-mail address missing";
$ERR_008 = "Please use a valid e-mail address";
$ERR_009 = "This username already exists";
$ERR_010 = "Username too short (min 5 chars)";
$ERR_011 = "Password too short (min 5 chars)";
$ERR_012 = "Address is missing";
$ERR_013 = "City is missing";
$ERR_014 = "Country is missing";
$ERR_015 = "ZIP/Post code missing";
$ERR_016 = "Please insert a valid ZIP/Post code";
$ERR_017 = "Item's title is missing";
$ERR_018 = "Item's description is missing";
$ERR_019 = "Starting bid missing";
$ERR_020 = "Minimum quantity field is not correct";
$ERR_021 = "Reserve price missing";
$ERR_022 = "The reserve price you inserted is not correct";
$ERR_023 = "Choose a category for your item";
$ERR_024 = "Choose a payment method";
$ERR_025 = "User does nto exist";
$ERR_026 = "Password incorrect";
$ERR_027 = "Currency symbol missing";
$ERR_028 = "Please use a valid e-mail address";
$ERR_029 = "This user is already registered";
$ERR_030 = "Fields must be numeric and in nnnn.nn format";
$ERR_031 = "The form you are submitting is not complete";
$ERR_032 = "One or both the e-mail addresses are not correct";
$ERR_033 = "Your bid is not correct: $bid";
$ERR_034 = "Your bid must be at least: ";
$ERR_035 = "Days field must be numeric";
$ERR_036 = "The seller cannot bid in his/her own auctions";
$ERR_037 = "Search keyword cannot be empty";
$ERR_038 = "Login incorrect";
$ERR_039 = "You have already confirmed your registration.";
$ERR_040 = "You are the winning bidder and cannot place a bid higher than your previous minimum bid.";
$ERR_041 = "Please choose a rating between 1 and 5";
$ERR_042 = "You comment is missing";
$ERR_043 = "Incorrect date format.";
$ERR_044 = "Cookies must be enabled to login.";
$ERR_045 = "No closed auctions for this user.";
$ERR_046 = "No active auctions for this user.";
$ERR_047 = "Required fields missing";
$ERR_048 = "Incorrect login";
$ERR_049 = "Database connection failed. Please edit your includes/passwd.inc.php
            file to set your database parameters.";
$ERR_050 = "Acceptance text missing";
$ERR_051 = "Please insert a valid number of digits";
$ERR_052 = "Please insert the number of news items to show in the news box";
$ERR_053 = "Please insert a valid number of news";
$ERR_054 = "Please fill in both the password fields";
$ERR_055 = "User <I>$_POST[username]</I> already exists";
$ERR_056 = "Bid decrement value missing";
$ERR_057 = "Bid decrement values must be numeric";
$ERR_058 = "Error";
$ERR_059 = "Your previous bid for this auction is higher than your current bid.<br />  You may not place a bid if your previous <b>amount of bid times the quantity</b> is greater than your <b>amount of current bid times the quantity</b>.";
$ERR_060 = "The end date is less than or equal to the start date. Change the auction's duration to fix this problem.";
//Added Aug.13,2002 by Mary
$ERR_061 = "The buy now price you inserted is not correct";
$ERR_062 = "You may not set a reserve price in a Dutch Auction";
$ERR_063 = "You may not use custom decrement in a Dutch Auction";
$ERR_064 = "You may not use the Buy Now feature in a Dutch Auction";
$ERR_065 = "Error updating information";
$ERR_066 = "Error deleting information";
// --
$ERR_100 = "User does not exist";
$ERR_101 = "Password incorrect";
$ERR_102 = "Username does not exist";
$ERR_103 = "You cannot rate yourself";
$ERR_104 = "All fields required";
$ERR_105 = "Username does not exist";
$ERR_106 = "<br /><br />No user specified";
$ERR_107 = "Username is too short";
$ERR_108 = "Password is too short";
$ERR_109 = "Passwords do not match";
$ERR_110 = "E-mail address incorrect";
$ERR_111 = "Such a user already exists";
$ERR_112 = "Data missing";
$ERR_113 = "You must be at least 16 years old to register";
$ERR_114 = "No active auctions for this category";
$ERR_115 = "E-mail address already used";
$ERR_116 = "No help available on that topic.";
$ERR_117 = "Incorrect date format";
// // ================================================================================
// // GIAN-- Jan. 19, 2002 -- Added for Pro version
$ERR_118 = "countries.txt file not found in the <FONT FACE=Courier>admin</FONT> directory.";
$ERR_119 = "sample error message for preview purposes.<br />
                        MySQL said: cannot connect to server (localhost)";
$ERR_120 = " is not enough to pay the sign up fee. Please, buy more credits.";
$ERR_121 = "You don't have enough credits to pay the set up fee. Please, <a HREF=buy_credits.php TARGET=_blank>buy more credits</a> and re-submit your auction.";
$ERR_122 = "No auction found";
// // ================================================================================
$ERR_600 = "Incorrect auction type";
$ERR_601 = "Quantity field not correct";
$ERR_602 = "Images must be GIF or JPG";
$ERR_603 = "The image is too large.";
$ERR_604 = "This auction already exists";
$ERR_605 = "The specified ID is not valid";
$ERR_606 = "The specified auction ID is not correct"; // used in bid.php
$ERR_607 = "Your bid is above the minimal bid";
$ERR_608 = "The specified quantity is not correct";
$ERR_609 = "User does not exist";
$ERR_610 = "Fill in your username and password";
$ERR_611 = "Password incorrect";
$ERR_612 = "You cannot bid, you are the seller!";
$ERR_613 = "You cannot bid, you are the higher bidder!";
$ERR_614 = "This auction is closed";
$ERR_615 = "You cannot bid above the minimum bid!";
$ERR_616 = "Post Code too short";
$ERR_617 = "Telephone number incorrect";
$ERR_618 = "Your account has been suspended or you didn't confirm it.";
$ERR_619 = "This auction has been suspended";
$ERR_620 = "Parent category has been deleted by the Administrator.";
$ERR_700 = "Incorrect date format";
$ERR_701 = "Invalid quantity (must be >0).";
$ERR_702 = "Current Bid must be less than minimum bid.";
// ADDED Feb.14, 2002 MARY LACEY
$ERR_703 = "<br />You may not leave feed about this user! <br />You are not a winner/seller in this  closed auction!";
$ERR_704 = "<br />You may not leave feedback about this user! <br />This auction is not closed!";
$ERR_705 = "You may only leave feedback, if you have a closed transaction with this user!";
// // GIAN-- Added on 03/07/2002 for ProPlus @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
$ERR_706 = "<I>Max. number of pictures</I> must be numeric.";
$ERR_707 = "<I>Max picture size</I> cannot be zero.";
$ERR_708 = "<I>Max picture size</I> must be numeric.";
$ERR_709 = "The picture you uploaded is too big. It cannot exceed ";
$ERR_710 = "Wrong file type. Allowed types are: GIF, PNG and JPEG";
// //Added 08.03.02 Simokas
$ERR_711 = "You cannot buy, you are the seller!";
$ERR_712 = "<b>Buy It Now</b> is not available for this auction";
$ERR_713 = "Sorry, you are suspended by the administrator.";

$ERR_5000 = "Messages to show must be numeric";
$ERR_5001 = "Messages to show cannot be zero";
$ERR_5002 = "You must select at least one statistic type (accesses, browsers & platforms, by country)";
$ERR_5003 = "List name cannot be empty";
$ERR_5004 = "The auction you are trying to access is a private auction and you do not seem to be among the invited buyers.";
$ERR_5005 = "The seller of the auction you are trying to bid on,<br />put some restrictions on it and and you do not seem to be allowed to bid.";
$ERR_5006 = "The seller of the auction you are trying to bid on,<br />put some restrictions on it and and you do not seem to be allowed to bid.";
$ERR_5007 = "To set up a private auction you must select at least one user from the Invited Users list.";
$ERR_5008 = "The URL cannot be empty";
$ERR_5009 = "The Welcome Message cannot be empty (the logo is optional)";
$ERR_5010 = "Tax percentage must be numeric";
$ERR_5011 = "Invalid credit card number";
$ERR_5012 = "Invalid expiration date";
$ERR_5013 = "Credit card owner missing";
$ERR_5014 = "Subject or message missing";
$ERR_5015 = "Card ZIP/Post code missing";
$ERR_5016 = "includes/config.inc.php ";
$ERR_5017 = "includes/passwd.inc.php ";
$ERR_5018 = "\"uploaded/cache\" directory is not writable.<br />You must change the permissions of this directory in order to proceed with the installation (CHMOD to 777).<br />";
$ERR_5019 = "\"uploaded\" directory is not writable.<br />You must change the permissions of this directory in order to proceed with the installation (CHMOD to 777).<br />";
$ERR_5020 = "\"admin/backup\" directory is not writable.<br />You must change the permissions of this directory in order to proceed with the installation (CHMOD to 777).<br />";
$ERR_5021 = "One or more problems have been detected and are reported above.<br />Please fix them to proceed with the installation.";
$ERR_5022 = "Unable to connect to MySQL server: ";
$ERR_5023 = "Unable to select database: ";
$ERR_5024 = "Max. upload size must be numeric";
$ERR_5025 = " does not exists";
$ERR_5026 = " is not writable.<br />You must change the file permissions or the changes you make on this page will not take affect.";
$ERR_5027 = " does not exist on this server";
$ERR_5028 = " is not writable.<br /><b>You must change the permissions of this file in order to proceed with the installation </b>(CHMOD to 666).<br /><br />";
$ERR_5029 = "Name missing";
$ERR_5030 = "Username missing";
$ERR_5031 = "Password missing";
$ERR_5032 = "Please enter you password twice";
$ERR_5033 = "E-mail address missing";
$ERR_5034 = "Address missing";
$ERR_5035 = "City missing";
$ERR_5036 = "Province missing";
$ERR_5037 = "Country missing";
$ERR_5038 = "ZIP/Post code missing";
$ERR_5039 = "Telephone missing";
$ERR_5040 = "Birthdate missing";
$ERR_5041 = "Invoice limit cannot be empty";
$ERR_5042 = "The following files may not be writable:
<UL>
<LI>includes/invoice_header_text.EN.inc.txt
<LI>includes/invoice_footer_text.EN.inc.txt
</UL>
Please set permissions on that file to allow PHP scripts to write to them.";
$ERR_5043 = "Cannot create database &nbsp;";
$ERR_5044 = "<br /><br />The problem may be in your MySQL server configuration.  If you get this error, try creating a database using your web site control panel(or whatever method you use to create a database for your site). <br /> Retry the install script by selecting \"Use existing database\" above entering the name of the database you just created.  Then click continue below";
$ERR_5045 = "The reserve price cannot be greater than the minimum bid";
$ERR_5046 = "The buy now price cannot be greater than the minimum bid and/or the reserve price";

$ERR_25_001 = "To update/insert please change some label";
$ERR_25_002 = "Non numeric value in numeric variant";
$ERR_25_003 = "uploaded/cache";

// // UI Messages =============================================================
$MSG_001 = "Register now for FREE!";
$MSG_002 = "Your name";
$MSG_003 = "Username";
$MSG_004 = "Password";
$MSG_005 = "Password again";
$MSG_006 = "Your e-mail address";
$MSG_007 = "Submit";
$MSG_008 = "Delete";
$MSG_009 = "Address";
$MSG_010 = "City";
$MSG_011 = "County";
$MSG_012 = "Postal Code";
$MSG_013 = "Telephone";
$MSG_014 = "Country";
$MSG_015 = "--Select here";
$MSG_016 = "Thanks for registering!<br />
                        A confirmation e-mail has been sent to: ";
$MSG_017 = "Item title";
$MSG_018 = "Item description<br />(HTML allowed)";
$MSG_019 = "URL of picture<br />(optional)";
$MSG_020 = "Auction starts with";
$MSG_021 = "Reserve price";
$MSG_022 = "Duration";
$MSG_023 = "Country";
$MSG_024 = "ZIP/Post Code";
$MSG_025 = "Shipping conditions";
$MSG_026 = "Payment methods";
$MSG_027 = "Choose a category";
$MSG_028 = "Sell an item";
$MSG_029 = "No";
$MSG_030 = "Yes";
$MSG_031 = "Buyer pays shipping costs";
$MSG_032 = "Seller pays shipping costs";
$MSG_033 = "International shipping";
$MSG_034 = "Preview auction";
$MSG_035 = "Reset form";
$MSG_036 = "Submit my information";
$MSG_037 = "No image available";
$MSG_038 = "Buyer pays shipping expenses";
$MSG_039 = "No reserve price";
$MSG_040 = "Submit auction";
$MSG_041 = "Item category";
$MSG_042 = "Item description";
$MSG_043 = "Will NOT ship internationally";
$MSG_044 = "Fill in your username and password and submit the form.";
$MSG_045 = "Users management";
$MSG_046 = "You can still <a HREF='sell.php?mode=recall'> make changes</a> to your auction";
$MSG_047 = "Username";
$MSG_048 = "Password";
$MSG_049 = "If you are not registered, ";
$MSG_050 = "(min 5 chars)";
$MSG_051 = "Main page";
$MSG_052 = "Login";
$MSG_053 = "Edit admin e-mail";
$MSG_054 = "Submit new e-mail";
$MSG_055 = "Edit the admin e-mail address below";
$MSG_056 = "E-mail address updated";
$MSG_057 = "Edit the currency symbol below";
$MSG_058 = "Submit new currency";
$MSG_059 = "E-mail address updated";
$MSG_060 = "Currency symbol updated";
$MSG_061 = "INSTALLATION";
$MSG_062 = "ADMINISTRATION";
$MSG_063 = "CONFIGURATION";
$MSG_064 = "Step 1. - Create MySQL database";
$MSG_065 = "Step2. - Create necessary tables";
$MSG_066 = "Step 3. - Populate tables";
$MSG_067 = "View Open Auctions";
$MSG_068 = "Reset form";
$MSG_069 = "Auctions Duration";
$MSG_070 = "Use the checkbox Delete and the button DELETE to delete lines. Use the last line to add a new payment condition. Simplemente edita los campos de texto y pulsa Actualizar para guardar los cambios.";
$MSG_071 = "Update";
$MSG_072 = "Delete";
$MSG_073 = "Lines delete";
$MSG_074 = "Use the checkbox Delete and the button DELETE to delete lines. Simply edit the text fields and press UPDATE to save the changes.";
$MSG_075 = "Payment Methods";
$MSG_076 = "Currency Symbol";
$MSG_077 = "Edit admin e-mail address";
$MSG_078 = "Categories Table";
$MSG_079 = "Payment Methods";
$MSG_080 = "Auctions Duration";
$MSG_081 = "Countries Table";
$MSG_082 = "Categories Table";
$MSG_083 = "Countries Table";
$MSG_084 = "Message posted";
$MSG_085 = "";
$MSG_086 = "Categories table updated";
$MSG_087 = "Description";
$MSG_088 = "Delete";
$MSG_089 = "Process changes";
$MSG_090 = "Countries table updated";
$MSG_091 = "Change language";
$MSG_092 = "Edit, delete or add payment methods using the form below.";
$MSG_093 = "Payment methods table updated";
$MSG_094 = "Edit, delete or add countries using the form below.";
$MSG_095 = "Countries table updated";
$MSG_096 = "Actual language";
$MSG_097 = "Days";
$MSG_098 = "Registration confirmation";
$MSG_099 = "New auction confirmation";
$MSG_100 = "Your auction has been properly received.<br />A confirmation e-mail has been sent to your e-mail address.<br />";
$MSG_101 = "Auction URL: ";
$MSG_102 = " Go! ";
$MSG_103 = " Search ";
$MSG_104 = "Browse ";
$MSG_105 = "<div class='bidhistory'>View your bid history</div>";
$MSG_106 = "Send to a friend";
$MSG_107 = "User's e-mail";
$MSG_108 = "View picture";
$MSG_109 = "Item description";
$MSG_110 = "Country";
$MSG_111 = "Auction started";
$MSG_112 = "Auction ends";
$MSG_113 = "Auction ID";
$MSG_114 = "No picture available";
$MSG_115 = "Bid now!<br />It's FREE";
$MSG_116 = "Bid";
$MSG_117 = "Higher bidder";
$MSG_118 = "Ends within";
$MSG_119 = "# of bids";
$MSG_120 = "Bid decrement";
$MSG_121 = "Place Your Minimum Bid Here";
$MSG_122 = "Edit, delete or add auction durations using the form below";
$MSG_123 = "Durations table updated";
$MSG_124 = "Maximun bid";
$MSG_125 = "Seller";
$MSG_126 = " days, ";
$MSG_127 = "Starting bid";
$MSG_128 = "Bid Decrements";
$MSG_129 = "ID";
$MSG_130 = "Description";
$MSG_131 = "Days";
$MSG_132 = "";
$MSG_133 = "Bid decrements table";
$MSG_134 = "Current bid";
$MSG_135 = "Edit, delete or add decrements using the form below.<br />
            Be careful, there's no control over the table's values congruence.
            You must take care to check it yourself. The only data check performed is over the fields content (must be numeric) but the relation between them is not checked.<br />
            [<a HREF=\"javascript:window_open('incrementshelp.php','incre',400,500,30,30)\" CLASS=\"links\">Read more</a>]";
$MSG_136 = "and";
$MSG_137 = "Decrement";
$MSG_138 = "Back to the auction";
$MSG_139 = "Send this auction to a friend";
$MSG_140 = "Your friend's name";
$MSG_141 = "Your friend's e-mail";
$MSG_142 = "Your name";
$MSG_143 = "Your e-mail";
$MSG_144 = "Add a comment";
$MSG_145 = "Send to your friend";
$MSG_146 = "This auction has been forwarded to ";
$MSG_147 = "Send to another friend";
$MSG_148 = "Help";
$MSG_149 = "You can contact this user using the form below.";
$MSG_150 = "Send request";
$MSG_151 = " The e-mail you requested is ";
$MSG_152 = "Confirm your bid";
$MSG_153 = "To bid you must be registered. <b><a href=\"register.php\">Click here</a></b> to sign up!";
$MSG_154 = "You Are Bidding on:";
$MSG_155 = "Item:";
$MSG_156 = "Your bid:";
$MSG_157 = "";
$MSG_158 = "Submit my bid";
$MSG_159 = "Your bid has been registered";
$MSG_159 = "Bidder:";
$MSG_160 = "Decrements table updated";
$MSG_161 = "Edit, delete or add categories using the form below.<br />[<a HREF=\"javascript:window_open('categorieshelp.php','incre',400,300,30,30)\" CLASS=\"links\">Read more</a>]";
$MSG_162 = "";
$MSG_163 = "Register!";
$MSG_164 = "Help";
$MSG_165 = "Category: ";
$MSG_166 = "Home";
$MSG_167 = "Picture";
$MSG_168 = "Auction";
$MSG_169 = "Actual bid";
$MSG_170 = "Bids #";
$MSG_171 = "Ends in";
$MSG_172 = "No active auctions in this category";
$MSG_173 = "Search result: ";
$MSG_174 = "Bid";
$MSG_175 = "Date and hour";
$MSG_176 = "Bidder";
$MSG_177 = "Categories index";
$MSG_178 = "Contact the bidder";
$MSG_179 = "To get another user's e-mail address, just fill in your username and password.";
$MSG_180 = " is:";
$MSG_181 = "User's login";
$MSG_182 = "Edit your personal data";
$MSG_183 = "Your data has been updated";
$MSG_184 = "Categories table has been updated.";
$MSG_185 = "Help";
$MSG_186 = "<a HREF=\"javascript:history.back()\">Back</a>";
$MSG_187 = "Your username";
$MSG_188 = "Your password";
$MSG_189 = "Your e-mail";
$MSG_190 = "Your item's category";
$MSG_191 = "Payment methods";
$MSG_192 = "Shipping conditions";
$MSG_193 = "Auction's duration";
$MSG_194 = "Starting bid";
$MSG_195 = "Picture's URL";
$MSG_196 = "Item's description";
$MSG_197 = "Auction's title";
$MSG_198 = "No items found";
$MSG_199 = "Search";
$MSG_200 = "User: ";
$MSG_201 = "new user";
$MSG_202 = "Users's data";
$MSG_203 = "Active auctions";
$MSG_204 = "Ended Auctions";
$MSG_205 = "Your Control Panel";
$MSG_206 = "User's profile";
$MSG_207 = "Leave Feedback";
$MSG_208 = "View Feedback";
$MSG_209 = "Registered user since: ";
$MSG_210 = "Contact with ";
$MSG_211 = "";
$MSG_212 = "Auctions:";
$MSG_213 = "View active auctions";
$MSG_214 = "View closed auctions";
$MSG_215 = "Forgot your password?";
$MSG_216 = "If you have lost or forgotten your password, please fill in your username and e-mail below.<br />A new password will be generated for you";
$MSG_217 = "Phew, a new password has been sent to your e-mail address.";
$MSG_218 = "View user's profile";
$MSG_219 = "Active auctions: ";
$MSG_220 = "Closed auctions: ";
$MSG_221 = "User login";
$MSG_222 = "User Feedback";
$MSG_223 = "Leave your comment";
$MSG_224 = "Choose a rating between 1 and 5";
$MSG_225 = "Thanks for leaving your comment";
$MSG_226 = "Your rating ";
$MSG_227 = "Your comment ";
$MSG_228 = "Valued by ";
$MSG_229 = "Newest feedback:";
$MSG_230 = "View all feedback";
$MSG_231 = "REGISTERED USERS";
$MSG_232 = "AUCTIONS ";
$MSG_233 = "More";
$MSG_234 = "Back &gt;&gt;";
$MSG_235 = "Register now";
$MSG_236 = "Sell an item";
$MSG_237 = "Bid";
$MSG_238 = "Search";
$MSG_239 = "Auctions";
$MSG_240 = "From";
$MSG_241 = "To";
$MSG_242 = "Decrement";
$MSG_243 = "If you want to change your password, please fill in the two fields below. Otherwise leave them blank.";
$MSG_244 = "Edit data";
$MSG_245 = "Logout";
$MSG_246 = "Logged in";
$MSG_247 = "User: ";
$MSG_248 = "Confirm your registration";
$MSG_249 = "Confirm";
$MSG_250 = "Refuse";
$MSG_251 = "---- Select here";
$MSG_252 = "Birthdate";
$MSG_253 = "(mm/dd/yyyy)";
$MSG_254 = "Suggest a new category";
$MSG_255 = "Auction's ID";
$MSG_256 = "Or select the image you want to upload (optional)";
$MSG_257 = "Auction's type";
$MSG_258 = "Items quantity";
$MSG_259 = "Login";

$MSG_261 = "Auction type";
$MSG_262 = "Your suggestion";
$MSG_263 = "Register now!";
$MSG_264 = "You still can ";
$MSG_265 = "make changes";
$MSG_266 = " to this auction";
$MSG_267 = "If you reached this page, you or someone claiming to be you, signed up at this site.
                                <br />To confirm your registration simply press the <b>Confirm</b> button below.
                                <br />If you didn't want to register and want to delete your data from our database, use the <b>Refuse</b> button.";
$MSG_268 = "Password";
$MSG_269 = "Your bid has been registered";
$MSG_270 = "Back";
$MSG_271 = "Your bid has been placed!";
$MSG_272 = "Auction:";
$MSG_273 = "To bid you must be registered. <b><a href=\"register.php\">Click here</a></b> to sign up!";
$MSG_274 = "Home";
$MSG_275 = "Go!";
$MSG_276 = "Categories";
$MSG_277 = "All categories";
$MSG_278 = "Last created auctions";
$MSG_279 = "Higher bids";
$MSG_280 = "Next Ending!";
$MSG_281 = "Help Column";
$MSG_282 = "News";
$MSG_283 = "minimum";
$MSG_284 = "Quantity";
$MSG_285 = "Go back";
$MSG_286 = " and specify a valid bid.";
$MSG_287 = "Category";
$MSG_288 = "Search keyword(s) cannot be empty";
$MSG_289 = "Total pages:";
$MSG_290 = "Total items:";
$MSG_291 = "items per page shown";
$MSG_292 = "All categories";
$MSG_293 = "NICK";
$MSG_294 = "NAME";
$MSG_295 = "COUNTRY";
$MSG_295c = "CREDITS";
$MSG_296 = "E-MAIL";
$MSG_297 = "ACTION";
$MSG_298 = "Edit";
$MSG_299 = "Delete";
$MSG_300 = "Suspend";
$MSG_301 = "members";
$MSG_302 = "Name";
$MSG_303 = "E-mail";
$MSG_304 = "Delete user";
$MSG_305 = "Suspend user";
$MSG_306 = "Reactivate user";
$MSG_307 = "Are you sure you want to delete this user?";
$MSG_308 = "Are you sure you want to suspend this user?";
$MSG_309 = "Are you sure you want to reactivate this user?";
$MSG_310 = "Reactivate";
$MSG_311 = "auctions found in the database";
$MSG_312 = "TITLE";
$MSG_313 = "USER";
$MSG_314 = "DATE";
$MSG_315 = "DURATION";
$MSG_316 = "CATEGORY";
$MSG_317 = "DESCRIPTION";
$MSG_318 = "CURRENT BID";
$MSG_319 = "QUANTITY";
$MSG_320 = "RESERVE PRICE";
$MSG_321 = "Suspend auction";
$MSG_322 = "Reactivate auction";
$MSG_323 = "Are you sure you want to suspend this auction?";
$MSG_324 = "Are you sure you want to reactivate this auction?";
$MSG_325 = "Delete auction";
$MSG_326 = "Are you sure you want to delete this auction?";
$MSG_327 = "MINIMUM BID";
$MSG_328 = "Color";
$MSG_329 = "Image Location";
$MSG_330 = "Thank you for confirming your registration.<br />You can now start bidding!<br />";
$MSG_331 = "Your registration has been deleted permanently from our database.";
$MSG_332 = "Subject";
$MSG_333 = "Message";
$MSG_334 = "Contact with";
$MSG_335 = "Contact from ";
$MSG_336 = "regarding your auction ";
$MSG_337 = "Your message has been sent to ";
$MSG_338 = "Delete new";
$MSG_339 = "Are you sure you want to delete this news?";
$MSG_340 = "News list";
$MSG_341 = "View all news";
$MSG_342 = " News";
$MSG_343 = "Edit news";
// // ================================================================================
// // GIAN-- Jan. 19, 2002 -- Added for Pro version
$MSG_344 = "Time Settings";
$MSG_345 = "If you want to adjust your server time to accurately show your local time, choose the correction (+ or -) amount from your server time that you want to apply.<br />
                        All the time functions in the program will apply the chosen adjustment.";
$MSG_346 = "Time Adjustment";
$MSG_347 = "Time settings updated";
$MSG_348 = "Batch Procedures Settings";
$MSG_349 = "GENERAL INFORMATION";
$MSG_350 = "Registered Users";
$MSG_351 = "Active Users";
$MSG_352 = "Inactive Users";
$MSG_353 = "Active Auctions";
$MSG_354 = "Closed Auctions";
$MSG_355 = "# Bids";
$MSG_356 = "Transactions";
$MSG_357 = "Total Amount";
$MSG_358 = "since";
$MSG_359 = "Reset Transactions Counters";
$MSG_360 = "Transactions";
$MSG_361 = "Users and Auction";
$MSG_362 = "Values since ";
$MSG_363 = "Dates Format";
$MSG_364 = "Fees";
$MSG_365 = "Admin Users";
$MSG_366 = "Registered Users";
$MSG_367 = "New admin user";
$MSG_368 = "CATEGORIES";
$MSG_369 = "New Categories Tree";
$MSG_370 = "OTHER TABLES";
$MSG_371 = "HAPPYBID needs to periodically run <CODE>cron.php</CODE> to close expired auctions and
                        send notification e-mails to the seller and/or the winner.
                        The recommended way to run <CODE>cron.php</CODE> is to set up a <a HREF=\"http://www.aota.net/Script_Installation_Tips/cronhelp.php4\" TARGET=_blank>cronjob</a> if you
                        run a Unix/Linux server.<br />
                        If for any reason you can't run a cronjob on your server, you can choose the <b>Non-batch</b> option below
                        to have <CODE>cron.php</CODE> run by HAPPYBID itself: in this case <CODE>cron.php</CODE> will be run each time someone access your home page.";
$MSG_372 = "Run cron";
$MSG_373 = "Batch";
$MSG_374 = "Non-batch";
$MSG_375 = "According to the default in HAPPYBID's Settings, <CODE>cron.php</CODE> automatically deletes auctions older than 30 days.
                        <br />You may change the time period below.";
$MSG_376 = "Delete auctions older than";
$MSG_377 = " days";
$MSG_378 = "Batch settings updated.";
$MSG_379 = "Choose the date format you want to use below.";
$MSG_380 = "USA format";
$MSG_381 = "Non-USA format";
$MSG_382 = "mm/dd/yyyy";
$MSG_383 = "dd/mm/yyyy";
$MSG_384 = "Date format updated.";
$MSG_385 = "SELLERS' FEES";
$MSG_386 = "AUCTIONS";
$MSG_387 = "Sellers' Setup Fee";
$MSG_388 = "Sellers' Final Value Fee";
$MSG_389 = "BUYERS' FEE";
$MSG_391 = "Activate Setup Fee?";
$MSG_392 = "Fee value";
$MSG_393 = "% of the initial price";
$MSG_394 = "Sellers setup fee settings updated";
$MSG_396 = "Activate Final Value Fee?";
$MSG_397 = "Seller Final Value Fee settings updated";
$MSG_398 = "Payment Gateways";
$MSG_399 = "If you are going to set up the options to charge sellers and/or buyers, please provide your <a HREF=http://www.paypal.com/ TARGET=_blank>PayPal</a>.
                        <br />[<a HREF=\"javascript:window_open('paypalhelp.php','incre',400,500,30,30)\">Read more</a>]";
$MSG_400 = "E-mail&nbsp;address";
$MSG_401 = "PayPal e-mail address updated.";
$MSG_402 = "Buyers Final Value Fee";
$MSG_404 = "Signup Fee settings updated";
$MSG_405 = "If you edited categories.txt click on the <FONT FACE=Courier>Start&nbsp;&gt;&gt;</FONT> button below";
$MSG_406 = "Start&nbsp;&gt;&gt;";
$MSG_407 = "A new categories tree has been created according to the content of your <a HREF=categories.txt>categories.txt</a> file.<br /><br />
You can make changes to your directories tree accessing the <a HREF=categories.php>Categories Administration Module</a>";
$MSG_408 = "Are you sure you want to reset the counters?";
$MSG_409 = "Error Handling";
$MSG_410 = "Fatal errors that occur during HAPPYBID's execution (typically MySQL errors) will redirect users to an error page.
                        You can customize the error message you want to appear in the error page below.<br />
                        NOTE: HTML tags are allowed.";
$MSG_411 = "Error Text";
$MSG_412 = "Error E-mail Address";
$MSG_413 = "Error Handling settings updated.";
$MSG_414 = "Preview Error Page";
$MSG_415 = "Error";
$MSG_416 = "Please report the above error message to:";
$MSG_417 = "Sign up Fee";
$MSG_419 = "Activate Sign Up Fee?";
$MSG_420 = "Thanks for registering at&nbsp;";
$MSG_421 = "To complete the sign-up process you should now pay the registration fee of&nbsp;";
$MSG_422 = "Please, click on the <b>Buy Credits!</b> button below to add credits to your credit account and confirm your registration.<br />
                        You will be automatically charged the sign up fee.";
$MSG_423 = "Thanks for setting up an auction at&nbsp;";
$MSG_424 = "To make your auction visible to all the users and accept bids, you should now pay the set up fee of&nbsp;";
$MSG_425 = "<b>NOTE: You will be charged a ";
$MSG_426 = " % of the starting price of your auction</b>";
$MSG_427 = "<b>NOTE: You will be charged a fixed fee of";
$MSG_428 = " fee to set up your auction.";
$MSG_429 = "There were no bids or reserve price was not met";
$MSG_430 = "Your Credits Account";
$MSG_431 = "Buy Credits";
$MSG_432 = "Date";
$MSG_433 = "Withdrawals";
$MSG_434 = "Deposits";
$MSG_435 = "Coin Balance";
$MSG_436 = "Currency:&nbsp;";
$MSG_437 = "Account Balance: ";
$MSG_438 = "To add credits to your account please, fill in the desired amount below and click on the <b>Buy Credits</b> button.";
$MSG_440 = "Amount";
$MSG_441 = "Buy Credits";
$MSG_442 = "If you are sure you want to add&nbsp;";
$MSG_443 = "&nbsp;to your account, choose your preferred payment option below.<BR /><BR />";
$MSG_444 = "Your payment has been successfully processed.<br />
                        Your <a HREF=\"credits_account.php\">credit account</a> has been updated to include the amount you just submitted.";
$MSG_445 = "You cancelled your Payment. You have not been charged and no credits have been added to <a HREF=\"credits_account.php\">your account</a>";
$MSG_446 = "Credits purchased";
$MSG_447 = "Buy Credits!";
$MSG_448 = "If you reached this page, you or someone claiming to be you, signed up at this site.
                        <br />To confirm your registration, you must first pay the sign up fee.
                        <br />Please click on the <b>Buy Credits!</b> button below to add credits to your account.";
$MSG_449 = "Sign Up Fee";
$MSG_450 = "Auction Setup Fee";
$MSG_451 = "Your account has been charged&nbsp;";
$MSG_452 = "Auction Final Value Fee";
$MSG_453 = "Winners details";
$MSG_454 = "Won auctions";
$MSG_455 = "Winner";
$MSG_456 = "Winner's E-mail";
$MSG_457 = "Winner's Bid";
$MSG_458 = "Auction:&nbsp;";
$MSG_459 = "Seller";
$MSG_460 = "Seller's E-mail";
$MSG_461 = "Your Bid";
$MSG_462 = "Bidfind";
$MSG_463 = "<a HREF=http://www.bidfind.com TARGET=_blank>Bidfind</a> is a search directory of auction items.
                    Bidfind agent needs to find a megalist file to";
$MSG_464 = "Advanced Search";
$MSG_465 = "Advanced Search";
$MSG_466 = "Search!";
$MSG_467 = "(mm/dd/yyyy)";
$MSG_468 = "You can choose between two ways to charge fees to your users:<OL>
<LI><b>Pay:</b> users will have to pay to your Paypal account everytime a fee is required
<LI><b>Prepay:</b> users will have to prepay (buy credits) before they access the services you decided to charge for
</OL>";
$MSG_469 = "Current setting is:";
$MSG_470 = "% of the final price";
// // ================================================================================
// // Added by Simokas
// // ================================================================================
$MSG_471 = "Auction Watch";
$MSG_472 = "Watcged auctions";
$MSG_473 = "Enter keyword(s)";
$MSG_474 = "Keyword(s) updated";
$MSG_475 = "Watched auctions";
// //Added by Mary 02-16-02
$MSG_476 = "RATING";
$MSG_477 = "<br />You do not have any feedback at this time.<br />";
$MSG_478 = "View Feedback";

// =======
$MSG_479 = "Switch to ";
$MSG_480 = "To complete the sign up process, please proceed to pay the sign up fee of ";
$MSG_481 = " by clicking on payment option of your choice below. ";
$MSG_482 = "Pay the sign up fee";
$MSG_483 = "Your Account";
$MSG_484 = "Your auction has been properly received.<br />
        To activate it, please proceed to pay the ";
$MSG_485 = " fee by clicking on the Paypal logo below.";
$MSG_486 = " Setup fee for auction: ";
$MSG_487 = "Amount";
$MSG_488 = "Auction Setup Fee Confirmation";
$MSG_489 = "Buyer and/or seller fee is still due for this auction";
$MSG_490 = "Seller's fee is still due for this auction";
$MSG_491 = "Buyer's's fee is still due for this auction";
$MSG_492 = "PAY FEE";
$MSG_493 = "Fee amount: ";
$MSG_494 = "Please proceed to pay the fee of ";
$MSG_495 = "Auction Final Value Fee for ";
// // Added by Simokas 08.03.02
$MSG_496 = "Buy Now";
$MSG_497 = "Buy Now Price";
$MSG_498 = "Item purchased successfully<br />";
$MSG_500 = "More";
$MSG_501 = "Home";
$MSG_502 = "Number of feedbacks";
$MSG_503 = "Feedback";
$MSG_504 = "COMMENT";
$MSG_505 = "Back to user's profile";
$MSG_506 = "sent feedback on: ";
$MSG_507 = "<div class='bidhistory'>Hide your bid history</div>";
$MSG_508 = "[user e-mail]";
$MSG_509 = "Edit your account";
$MSG_510 = "Your account information has been updated";
$MSG_511 = "Edit user";
$MSG_512 = "Edit auction";
$MSG_513 = "Suggest a category";
$MSG_514 = "Reserve price has not been met";
$MSG_515 = "Reserve price has been reached";
$MSG_516 = "News Management";
$MSG_517 = " news found in the database";
$MSG_518 = "Add new";
$MSG_519 = "Title";
$MSG_520 = "Content";
$MSG_521 = "Activate";
$MSG_522 = "Date";
$MSG_523 = "Note: Cookies must be enabled to login.";
$MSG_524 = "SETTINGS";
$MSG_525 = "Admin users management";
$MSG_526 = "General Settings";
$MSG_527 = "Site name";
$MSG_528 = "Site URL";

$MSG_530 = "Save changes";
$MSG_531 = "Your logo";
$MSG_532 = "Display login box?";
$MSG_533 = "Display news box?";
$MSG_534 = "Show acceptance text?";

$MSG_537 = "Select <b>Yes</b> if you want the users login box to be displayed in the Home page. Otherwise select <b>No</b>";
$MSG_538 = "Select <b>Yes</b> if you want the news box to be displayed in the Home page. Otherwise select <b>No</b>";
$MSG_540 = "Admin e-mail";
$MSG_541 = "The admin e-mail address is used to send automatic e-mail messages";
$MSG_542 = "General settings updated";
$MSG_543 = "Admin home";
$MSG_544 = "Money format";
$MSG_545 = "US style: 1,250.00";
$MSG_546 = "European style: 1.250,00";
$MSG_547 = "Set to zero or leave blank if you don't want decimal digits in your money representation";
$MSG_548 = "Decimal digits";
$MSG_549 = "Symbol position";
$MSG_550 = "Before the amount (i.e. USD 200)";
$MSG_551 = "After the amount (i.e. 200 USD)";
$MSG_552 = "Currency Symbol";
$MSG_553 = "Currency settings updated";
$MSG_554 = "Number of news you want to show";
$MSG_555 = "Fonts and Colors";
$MSG_556 = "Current logo";
$MSG_557 = "Username";
$MSG_558 = "Created";
$MSG_559 = "Last login";
$MSG_560 = "Status";
$MSG_561 = "DELETE";
$MSG_562 = "Edit admin user";
$MSG_563 = "If you want to change the user's password use the two fields below. To maintain the current password leave them blank.";
$MSG_564 = "Repeat password";
$MSG_565 = "User is";
$MSG_566 = "active";
$MSG_567 = "not active";
$MSG_568 = "New admin user";
$MSG_569 = "Insert user";
$MSG_570 = "Never logged in";
$MSG_571 = "Standard font";
$MSG_572 = "Error font";
$MSG_573 = "Small font";
$MSG_574 = "Footer font";
$MSG_575 = "Title font";
$MSG_576 = "This is the font used to display error message";
$MSG_577 = "This is the basic font used to display all the site's text, if not otherwise specified.<br />";
$MSG_578 = "Face";
$MSG_579 = "Size";
$MSG_580 = "Color";
$MSG_581 = "Bold";
$MSG_582 = "Italic";
$MSG_583 = "The <b>Small font</b> format is used to display minor text like date in the header of the pages";
$MSG_584 = "This is the font used to display texts in the footer fo the pages";
$MSG_585 = "This is the font used in the titles of pages";
$MSG_586 = "Border color";
$MSG_587 = "This is the color of the border of the most external box";
$MSG_588 = "Navigation font";
$MSG_589 = "This is the font format of the navigation links in the header of the pages";
$MSG_590 = "Header background color";
$MSG_591 = "Tables header color";
$MSG_592 = "Logged in as: ";
$MSG_593 = "Fonts and colors settings updated";
$MSG_594 = "<br />
                        <FONTs COLOR=RED><b>Note:</b> for this utility to work, the number format MUST follow the USA style notation.<br />
                    Your <a HREF=currency.php>currency settings</a> will be ignored here.";
$MSG_595 = "Links Color";
$MSG_596 = "Visited Links Color";
$MSG_597 = "Activate banners support?";
$MSG_599 = "Banners Management";
$MSG_600 = "Banners settings updated";
$MSG_601 = "Access PhpAdsNew administration back-end.";
$MSG_602 = "Upload a new logo (max. 50 Kbytes)";
$MSG_603 = "Activate Newsletter?";
$MSG_604 = "If you activate this option, users will be able to subscribe to your newsletter from the registration page.<br />
                        The \"Newsletter management\" will let you send e-mail messages to the subscribed users";
$MSG_605 = "Message Body";
$MSG_606 = "Subject";
$MSG_607 = "Newsletter Submission";
$MSG_608 = "Would you like to receive our Newsletter?";
$MSG_609 = "Check NO to unsubscribe to our Newsletter";
$MSG_610 = "<b>If you want to change your password, please fill in the two fields below, otherwise leave them blank.</b>";
$MSG_611 = "<b>This item has been viewed</b>";
$MSG_612 = "<b>times</b>";
$MSG_613 = "Bid decrement";
$MSG_614 = "Use the built-in proportional decrements table";
$MSG_615 = "Use your custom fixed decrement";
$MSG_616 = "Decrement";
$MSG_617 = "*NOTE* Change your password by using the fields below. Otherwise leave them blank.";
$MSG_618 = "Your auctions";
$MSG_619 = "Open Auctions";
$MSG_620 = "Bid history";
$MSG_621 = "Edit your personal profile";
$MSG_622 = "My control panel";
$MSG_623 = "Closed Auctions";
$MSG_624 = "Auction's title";
$MSG_625 = "Started";
$MSG_626 = "Ends";
$MSG_627 = "N. Bids";
$MSG_628 = "Max. Bid";
$MSG_629 = "Ended";
$MSG_630 = "Re-list";
$MSG_631 = "Process selected auctions";
$MSG_632 = "Edit auction";
$MSG_633 = "This is the color of the table headers in the main page";
$MSG_634 = "The main header, columns and auction rows, will be this color";
$MSG_635 = "To change your item's picture use the fields below.";
$MSG_636 = "Current picture";
$MSG_637 = "Back to auctions list";
$MSG_638 = "Bids You Have Placed";
$MSG_639 = "Your Bid History";
$MSG_640 = "*Note* If Dutch Auction you may not set a reserve price, custom decrement amount or use the BUY NOW feature.";
$MSG_641 = "Dutch auction";
$MSG_642 = "Standard reverse auction";
$MSG_643 = "\n\nThe winning bid amount is:";
$MSG_644 = "To populate the categories tree from scratch, you must first edit the
                        <a HREF=categories.txt>categories.txt</a> you find in the \"admin\" directory following the instructions contained in <a HREF=\"../docs/CATEGORIES\">docs/CATEGORIES</a>.";
$MSG_645 = "Post question for Seller";
$MSG_646 = "You must be logged in to ask questions to the seller";
$MSG_647 = "Ask";
$MSG_648 = "Reply to questions";
$MSG_649 = "Answer:";
$MSG_650 = "Question:";
$MSG_651 = "Ask something to";
$MSG_652 = "Back to Top";
$MSG_653 = "Nickname:";
$MSG_654 = "Date:";
// // GIAN march 2, 2002
$MSG_655 = "Updates and Upgrades";
$MSG_657 = "Check updates database";
$MSG_658 = "No new files found.";
$MSG_659 = "Please, select below the file(s) you want to update or install.";
$MSG_662 = "Process selected files";
// // GIAN-- 03/07/2002 addec for Pro Plus
$MSG_663 = "Picture Gallery";
$MSG_664 = "If you activate this option, sellers will be able to upload additional pictures
            up to the maximum you specifiy (see below).<br />
            Remember you can set up a fee for the additional pictures sellers upload:
            see the <a HREF=picturesgalleryfee.php>fees section</a>.";
$MSG_665 = "Activate Picture Gallery?";
$MSG_666 = "Max. Number of pictures";
$MSG_667 = "Picture Gallery settings updated";
$MSG_668 = "Picture Gallery fee";
$MSG_669 = "You can charge sellers for the additional pictures they upload or leave this service free.";
$MSG_670 = "Activate Picture Gallery fee?";
$MSG_671 = "Max. pictures size";
$MSG_672 = "Kbytes";
$MSG_673 = "You can upload up to ";
$MSG_674 = "pictures.";
$MSG_675 = "You will be charged ";
$MSG_676 = "for each picture you upload.";
$MSG_677 = "Upload Pictures";
$MSG_678 = "Close";
$MSG_679 = "Please, follow the steps below.";
$MSG_680 = "Select the file to upload";
$MSG_681 = "Upload file";
$MSG_682 = "Repeat steps 1. and 2. for each picture. When finished click on the <I>Create Gallery</I> button below.";
$MSG_683 = "&gt;&gt;&gt; Create Gallery &lt;&lt;&lt;";
$MSG_684 = "Filename";
$MSG_685 = "Size (bytes)";
$MSG_686 = "Delete";
$MSG_687 = "Uploaded Files";
$MSG_688 = "You already uploaded ";
$MSG_689 = " files";
$MSG_690 = "SetUp Fee";
$MSG_691 = "Picture Gallery Fee";
$MSG_692 = "Edit Picture Gallery";
$MSG_693 = "&gt;&gt;&gt; Update Gallery &lt;&lt;&lt;";
$MSG_694 = "View Picture Gallery";
$MSG_695 = "Repeat steps 1. and 2. for each picture. When finished click on the <I>Update Gallery</I> button below.";
$MSG_696 = "Pictures Gallery Fee: ";
$MSG_697 = "You can delete and add pictures to your gallery below.
            <br />Your gallery can contain up to ";
$MSG_698 = "pictures (number of pictures of your original gallery)";
// // MBL-- 03/10/2002 added for Pro Plus Proxy Bidding
$MSG_699 = "Your bid of ";
$MSG_700 = " has been entered. ";
$MSG_701 = " Your bid was not enough to make you the highest bidder!<br />Would you like to bid again?";
$MSG_702 = " Auto Bidding?";
// // GIAN-- 03/11/2002 For Bulk Upload +++++++++++++++++++++++
$MSG_703 = "Bulk Auctions Upload";
$MSG_704 = "Using this feature, you will be able to upload multiple items .<br />
<br />Once uploaded, the auctions will be created, but not listed(live).  You will be able to review the items from  <a HREF=yourauctions_b.php>Your Bulk Uploaded Auctions</a> section. After reviewing your items, you must list them one by one to go live.
<br /><br />
Auctions' data must be stored in a text file with fields separated by TABs following
<a HREF=\"Javascript:window_open('bulkschema.php','bulkschema',400,500,20,20)\">this schema</a>.
<br /><br />You will also need to know the numeric codes for the categories to be able to populate your file with the correct information.";
$MSG_705 = "Bulk Upload File Schema";
$MSG_706 = "Below is the list of fields you can upload for your auctions, along with their format and/or values .<br />
            <br />In your file, each auction is represented by a line and the fields must be separated by a TAB character.";
$MSG_707 = "Field";
$MSG_708 = "Value";
$MSG_709 = "A text string up to 255 characters long";
$MSG_710 = "Item Description";
$MSG_711 = "A description text up to 65535 characters long";
$MSG_712 = "You will find the category id <a HREF=\"Javascript:window_open2('catids.php','catids',700,640,50,0)\">here</a>.";
$MSG_713 = "Category";
$MSG_714 = "Starting bid";
$MSG_715 = "The amount of the starting bid for your auction.";
$MSG_716 = "Reserve price";
$MSG_717 = "The amount of the reserve price. If you do not want to set a reserve price for your auction set this field to zero.";
$MSG_718 = "Auction Type";
$MSG_719 = "1 means <b>Standard Reverse Auction</b><br />2 means <b>Dutch Auction</b>";
$MSG_720 = "Duration";
$MSG_721 = "This is the duration of your auction.";
$MSG_722 = "Bids decrement";
$MSG_723 = "If you want to set a custom decrement, put its value here.<br />If you want your auction to follow the site's decrement system, set this field to zero.";
$MSG_724 = "Location";
$MSG_725 = "You will find the country id <a HREF=\"Javascript:window_open3('countryids.php','catids',700,640,50,0)\">here</a>.
";
$MSG_726 = "Location ZIP";
$MSG_727 = "The ZIP/Post code of the location where the item is actually located that you are going to sell";
$MSG_728 = "Shipping Expenses";
$MSG_729 = "1 means <b>Buyer pays shipping expenses</b><br />2 means <b>Seller pays shipping expenses</b>";
$MSG_730 = "Shipping";
$MSG_731 = "Whether you are going to ship internationally.<br />
            1 means <b>yes</b><br />2 means <b>no</b>";
$MSG_732 = "Quantity";
$MSG_733 = "How many items you are going to sell (this is usually 1 for standard auctions, a quantity value for dutch auctions)";
$MSG_734 = "<a HREF=\"Javascript:window_open('bulkschema.php','bulkschema',400,500,20,20)\">Categories</a>";
$MSG_735 = "<a HREF=\"Javascript:window_open('bulkschema.php','bulkschema',400,500,20,20)\">Categories</a>";
$MSG_734 = "<a HREF=\"Javascript:window_open('bulkschema.php','bulkschema',400,500,20,20)\">Categories</a>";
$MSG_737 = "Uploaded successfully!<br />Now go to <a HREF=yourauctions_b.php>Your Auctions</a> to edit the uploaded auctions.";
$MSG_738 = "Minimum Price";
$MSG_739 = "The price at which bidding starts";
$MSG_740 = "To get correct category or subcategory ids, select all categories from Browse menu. Find wanted category, if you hold your mouse cursor
over it you can see the id=number. The current number is the (sub)category id, which you need to input into the bulk upload text file.";
$MSG_741 = "Uploaded auctions";
$MSG_900 = "Auction type";
$MSG_901 = "Number of items";
$MSG_902 = "Quantity";
$MSG_903 = "Items quantity";
$MSG_904 = "This auction is closed";
$MSG_905 = "Check out this auction";
$MSG_906 = "Your bid is no longer the lowest unique";
$MSG_907 = "- Winner Information";
$MSG_908 = "- No Winner";
$MSG_909 = "Auction closed - you win!";
$MSG_910 = "No auctions exist for this user.";
$MSG_911 = "closed";
$MSG_912 = "Help Management";
$MSG_913 = "topics found in the database";
$MSG_914 = "Topic";
$MSG_915 = "Text";
$MSG_916 = "Help Topics Management";
$MSG_917 = "Add help topic";
$MSG_918 = "Other Help Topics:";
$MSG_919 = "General Help";
// // Added by Simokas 10.03.2002
$MSG_920 = "Activate Buy Now?";
$MSG_921 = "If you activate this option, users will be able to buy the item from the auction right away, if there are
no bids placed for this item. This option must first be enabled by seller who opens the auction.";
$MSG_922 = "Send e-mail to seller";
$MSG_923 = "Seller location";
$MSG_1000 = "Search keywords or item number";
$MSG_1001 = "Search Title <b>and</b> Description";
$MSG_1002 = "Search in Categories";
$MSG_1003 = "Price Range";
$MSG_1004 = "Between";
$MSG_1005 = "  and ";
$MSG_1006 = "Payment Choice";
$MSG_1007 = "Seller";
$MSG_1008 = "Located In";
$MSG_1009 = "Ending";
$MSG_1010 = "Today";
$MSG_1011 = "Tomorrow";
$MSG_1012 = "in 3 Days";
$MSG_1013 = "in 5 Days";
$MSG_1014 = "Sort by";
$MSG_1015 = "Items Ending First";
$MSG_1016 = "Newly Listed Items First";
$MSG_1017 = "Lowest Prices First";
$MSG_1018 = "Highest Prices First";
$MSG_1019 = "Auction Type";
$MSG_1020 = "Dutch Auction";
$MSG_1021 = "Standard Reverse Auction";
// // Mary added on March 12, 2002 for thanks,php and cancel.php
$MSG_1022 = "Your payment has been successful.  If you have any problems or questions, please contact ";
$MSG_1023 = "Support";
$MSG_1024 = "Thank you for your business!";
$MSG_1025 = "Your transaction was not successful. You should not incur any charges. An error occured during the payment process or you intentionally cancelled the transaction. ";
$MSG_1026 = "Support";
$MSG_1027 = "Thank you for your business!";
// // Gian - May 29, 2002
$MSG_1028 = "UPDATE COUNTERS";
$MSG_1029 = "Are you sure you want to update the counters?";
$MSG_1030 = "Update Counters Utility";
$MSG_1031 = "Starting counters update...";
// // GIAN - sept. 12 2002
$MSG_1050 = "SSL Support";
$MSG_1051 = "Activate SSL support?";
$MSG_1052 = "HTTPS URL";
$MSG_1053 = "The secure server you are using could be under a different domain name or path. Please provide it below.";
$MSG_1054 = "SSL settings updated";
$MSG_1055 = "[<a HREF=\"javascript:window_open('httpshelp.php','https',400,500,30,30)\" CLASS=\"links\">Read more</a>]";
$MSG_1056 = "Alignment";


$MSG_5000 = "Home Page Layout";
$MSG_5001 = "Fonts";
$MSG_5002 = "Colors";
$MSG_5003 = "Site Settings";
$MSG_5004 = "Currencies Settings";
$MSG_5005 = "General Layout Settings";
$MSG_5006 = "Picture Gallery Settings Updated";
$MSG_5007 = "Paypal Settings Updated";
$MSG_5008 = "Site Currency";
$MSG_5009 = "Other Currencies";
$MSG_5010 = "Currencies Converter";
$MSG_5011 = "Home Page Featured Items";
$MSG_5012 = "This is the number of featured items to show in the Home Page (NOTE: ONLY <b>featured</b> items will be displayed).<br />0
(zero) is permitted.";
$MSG_5013 = "Number of auctions which displayed on main page";
$MSG_5014 = "This is the number of most recent items to show in the Home Page.<br />0
(zero) is permitted.";
$MSG_5015 = "Higher Bids";
$MSG_5016 = "This is the number of items to show in the Higher Bids list in the Home Page.<br />0
(zero) is permitted.";
$MSG_5017 = "Next Ending";
$MSG_5018 = "This is the number of items to show in the Next Ending list in the Home Page.<br />0
(zero) is permitted.";
$MSG_5019 = "General Layout Settings Updated";
$MSG_5020 = "Font Settings Updated";
$MSG_5021 = "Color Settings Updated";
$MSG_5022 = "USERS SEARCH";
$MSG_5023 = "Search &gt;&gt;";
$MSG_5024 = "Name, nick or e-mail";
$MSG_5025 = "Account";
$MSG_5026 = "Add credits";
$MSG_5027 = "Charge credits";
$MSG_5028 = "Action";
$MSG_5029 = "GO >>";
$MSG_5030 = "Message Boards";
$MSG_5031 = "New Message Board";
$MSG_5032 = "Message Boards Management";
$MSG_5033 = "MESSAGE BOARDS LIST";
$MSG_5034 = "Board Title";
$MSG_5035 = "Messages to show";
$MSG_5036 = "This is the number of most recent messages to show for this message board.";
$MSG_5037 = "Create as";
$MSG_5038 = "Active";
$MSG_5039 = "Inactive";
$MSG_5040 = "NOTE: deleting a message board will delete all the associated messages.";
$MSG_5041 = "ID";
$MSG_5042 = "NAME";
$MSG_5043 = "# MSGS";
$MSG_5044 = "LAST MSG";
$MSG_5045 = "Delete";
$MSG_5046 = "SHOW";
$MSG_5047 = "Message Boards Settings";
$MSG_5048 = "Activate Message Boards Service?";
$MSG_5049 = "Show Message Boards link?";
$MSG_5050 = "Select <b>yes</b> if you want a link to the message boards to appear in the header and footer of your site.";
$MSG_5051 = "Message Boards Settings Updated";
$MSG_5052 = "Edit Message Board";
$MSG_5053 = "Last Message";
$MSG_5054 = "Board is";
$MSG_5055 = "Message Boards";
$MSG_5056 = "You are not logged in.<br />If you post a message it will appear as posted by <b><I>Unknown user</I></b>.";
$MSG_5057 = "Post Message";
$MSG_5058 = "Back to message boards";
$MSG_5059 = "Messages";
$MSG_5060 = "Posted by ";
$MSG_5061 = "Unknown user";
$MSG_5062 = "View all messages";
$MSG_5063 = "View/Edit Messages";
$MSG_5064 = "Back to message board";
$MSG_5065 = "Delete all messages older than";
$MSG_5066 = "Back";
$MSG_5067 = "Update Counters ";
$MSG_5068 = "Words Filter";
$MSG_5069 = "The Words Filter option gives you the possibility to eliminate undesired words from:
<UL>
<LI>TITLE and DESCRIPTION of the auctions.
<LI>Messages posted to the message boards";
$MSG_5070 = "Enable Words Filter?";
$MSG_5071 = "Undesired words list";
$MSG_5072 = "Enter the undesired words one per line (max. 255 characters per line). Note that each line will be
treated like \"one word\".";
$MSG_5073 = "Words Filter Settings Updated";
$MSG_5074 = "About Us";
$MSG_5075 = "Terms & Conditions Page";
$MSG_5076 = "Activate this option if you want an <U>About us</U> link to appear in the footer of your pages.";
$MSG_5077 = "Activate About us page?";
$MSG_5078 = "About us page content<br />(HTML allowed)";
$MSG_5079 = "About us Settings Updated";
$MSG_5080 = "Note: each new line character will be converted to <b>&lt;BR&gt;</b> HTML tag.";
$MSG_5081 = "Activate this option if you want a <U>Terms & Conditions</U> link to appear in the footer of your pages.";
$MSG_5082 = "Activate Terms & Conditions page?";
$MSG_5083 = "Terms & Conditions page content<br />(HTML allowed)";
$MSG_5084 = "Terms & Conditions Settings Updated";
$MSG_5085 = "About Us";
$MSG_5086 = "Terms & Conditions";
$MSG_5088 = "Home Page Featured Items Options";
$MSG_5089 = "Home Page Featured";
$MSG_5090 = "Bold Items";
$MSG_5091 = "Highlighted Items";
$MSG_5092 = "Auction Search";
$MSG_5093 = "Title, Description";
$MSG_5094 = "View&nbsp;auctions";
$MSG_5095 = "Back to users list &gt;&gt;";
$MSG_5096 = "Activate this option if you want your sellers to be able to create their auctions as <b><I>Home Page Featured</I></b>.<br />
Home Page Featured Auctions appear (randomly) in the home page according to what you set in the <a HREF=homepage.php>General Layout
Settings</a>.<br />
Don't forget to <a HREF=featuredfee.php>set up a fee</a> for this option.";
$MSG_5097 = "Activate this option if you want your sellers to be able to list their auctions as <b><I>Bold</I></b>.<br />
Bold Item titles will always appear in bold (i.e. in the auctions list while browsing categories).<br />
Don't forget to <a HREF=boldfee.php>set up a fee</a> for this option.";
$MSG_5098 = "Activate this option if you want your sellers to be able to list their auctions as <b><I>Highlighted</I></b>.<br />
Highlighted Item titles will always appear with a colored backgroud (i.e. in the auctions list while browsing categories).<br />
Don't forget to <a HREF=highlightedfee.php>set up a fee</a> for this option.";
$MSG_5099 = "Activate Home Page Featured Items?";
$MSG_5100 = "Home Page Featured Items Option Updated";
$MSG_5101 = "Bold Items Option Updated";
$MSG_5102 = "Highlighted Items Option Updated";
$MSG_5103 = "Activate Bold Items?";
$MSG_5104 = "Activate Highlighted Items?";
$MSG_5105 = "Other Fees";
$MSG_5106 = "Home Page Featured";
$MSG_5107 = "Bold Items";
$MSG_5108 = "";
$MSG_5108 = "Home Page Featured Items Option is: ";
$MSG_5109 = "Bold Items Option is: ";
$MSG_5110 = "Highlighted Items Option is: ";
$MSG_5111 = "ON";
$MSG_5112 = "OFF";
$MSG_5113 = "Change";
$MSG_5114 = "Highlighted Items";
$MSG_5115 = "days";
$MSG_5116 = "Bulk Uploaded auctions";
$MSG_5117 = "Page";
$MSG_5118 = "of";
$MSG_5119 = "&lt;&lt;Prev";
$MSG_5120 = "Next&gt;&gt;";
$MSG_5121 = "To increase you auction's visibility you may want to choose among the following options:";
$MSG_5122 = "Home Page Featured Item";
$MSG_5123 = "Highlighted Item";
$MSG_5124 = "Bold Item";
$MSG_5125 = "Your auction has been properly received.<br />
To activate it, please proceed to pay the fees detailed below";
$MSG_5126 = "Your item will randomly appear in the home page.";
$MSG_5127 = "Your item will always appear with a highlighted background.";
$MSG_5128 = "Your item's title will always appear in bold.";
$MSG_5129 = "Cost: ";
$MSG_5130 = "You selected the following options:";
$MSG_5131 = " % of the item's price";
$MSG_5132 = "Total";
$MSG_5133 = "Fees Resume";
$MSG_5134 = "Gallery Fee";
$MSG_5135 = "Your auction has been properly received.<br />To activate it, please proceed to pay the fees detailed below.";
$MSG_5136 = "Fees Resume";
$MSG_5137 = "Total";
$MSG_5138 = "Note: you can use the currency of your choice throughout the site.<br />
All the amounts users will have to pay at Paypal will be automatically converted to USD using  today's rate of exchange before being sent to the Paypal server.";
$MSG_5139 = "Auctions Management";
$MSG_5140 = "Account Management";
$MSG_5141 = "Access Statistics";
$MSG_5142 = "Settings";
$MSG_5143 = "View Access Statistics";

$MSG_5145 = "Generate user access statistics";
$MSG_5146 = "Generate browser and platform statistics";
$MSG_5148 = "Statistics Settings Updated.";
$MSG_5149 = "Activate Statistics?";
$MSG_5150 = "Select which type of statistics you want to generate";

$MSG_5152 = "<a HREF=\"javascript:window_open('ST_browsers.html','ST_browsers',400,500,30,30)\" CLASS=\"links\">Browsers</a>";
$MSG_5153 = "<a HREF=\"javascript:window_open('ST_platforms.html','ST_platforms',400,500,30,30)\" CLASS=\"links\">Platforms</a>";
$MSG_5154 = "<a HREF=\"javascript:window_open('ST_countries.php','ST_domains',400,500,30,30)\" CLASS=\"links\">Domains</a>";
$MSG_5155 = "Browsers";
$MSG_5156 = "Platforms";
$MSG_5157 = "Domains";
$MSG_5158 = "Access Statistics for ";
$MSG_5159 = "Day";
$MSG_5160 = "View historic";
$MSG_5161 = "Page views";
$MSG_5162 = "Unique visitors";
$MSG_5163 = "User sessions";
$MSG_5164 = "Totals";
$MSG_5165 = "View Browser Statistics";
$MSG_5166 = "View Domain Statistics";
$MSG_5167 = "Browser Statistics for ";
$MSG_5168 = "Domain Statistics for";
$MSG_5169 = "Browser";
$MSG_5170 = "Domain";
$MSG_5171 = "Invited Users Lists";
$MSG_5172 = "Banned Users List";
$MSG_5173 = "Create new list";
$MSG_5174 = "List name";
$MSG_5175 = "Members";
$MSG_5176 = "Delete selected lists";
$MSG_5177 = "Create &gt;&gt;";
$MSG_5178 = "Add user (nick)";
$MSG_5179 = "Search users";
$MSG_5180 = "User";
$MSG_5181 = "Add &gt;&gt;";
$MSG_5182 = "Search user (nick, name or e-mail)";
$MSG_5183 = "users found";
$MSG_5184 = "SELECT";
$MSG_5185 = "Nick";
$MSG_5186 = "Name";
$MSG_5187 = "Edit content of list: ";
$MSG_5188 = "Delete selected users";
$MSG_5189 = "Submit Auction";
$MSG_5190 = "Reset Fields";
$MSG_5191 = "Invited Users Lists and Banned Users List";
$MSG_5192 = "Set this auction as <b>private</b>: only users belonging to one of the selected Invited Users List will be able to access your auction and bid.<br />
If you don't select this option your auction will be public (visible to all users) but only invited users will be entitled to bid.";
$MSG_5193 = "Send invitation e-mail to the invited users";
$MSG_5194 = "Auction is private: ";
$MSG_5195 = "Send invitation e-mail to the invited users: ";
$MSG_5196 = "You have been invited as a selected buyer";
$MSG_5197 = "Invited Auctions";
$MSG_5198 = "Register now";
$MSG_5199 = "Submit bid";
$MSG_5200 = "Post question";
$MSG_5201 = "Post message";
$MSG_5202 = "Add to your watch list";
$MSG_5203 = "Delete";
$MSG_5204 = "Insert";
$MSG_5205 = "Enable/Disable";
$MSG_5206 = "WAP Settings";
$MSG_5207 = "Enabling <a HREF=http://www.wapforum.org/what/index.htm target=_BLANK>WAP</a> support for your site will give your users the ability to browse the categories and the auctions.<br />
Bidding is not supported.";
$MSG_5208 = "Enable WAP support?";
$MSG_5209 = "WAP settings updated";
$MSG_5211 = "WAP URL";
$MSG_5212 = "Home Page Settings";
$MSG_5213 = "Logo";
$MSG_5214 = "Welcome message";
$MSG_5215 = "Error Handling";
$MSG_5216 = "Activate?";
$MSG_5217 = "Activating Error Handling is highly recommended. In case of errors in the wap routines, an e-mail will
be sent to the site administrator (the e-mail address is the one you set in the <a HREF=settings.php>General Settings</a> section).";
$MSG_5218 = "The logo you upload will appear in the home page of the WAP site along with the welcome message you can set below.<br />
NOTE: the image you upload must be in WBMP format.";
$MSG_5219 = "Current logo: ";
$MSG_5220 = "Max. 255 chars";
$MSG_5221 = "Highlighted items background";
$MSG_5222 = "<b>NOTE: Home page featured items are shown in the home page, in rows of two auctions wide, so this number should be an even number.</b>";
$MSG_5223 = "Thumbnail width (This is best set at 195 pixels or less )";
$MSG_5224 = "pixels";
$MSG_5225 = "Home Page Featured Auctions";
$MSG_5226 = "View Closed Auctions";
$MSG_5227 = "View Suspended Auctions";
$MSG_5228 = "Show Home Page Logo?";
$MSG_5229 = "FAQs MANAGEMENT";
$MSG_5230 = "FAQs Categories";
$MSG_5231 = "New FAQ";
$MSG_5232 = "Manage FAQs";
$MSG_5233 = "OTHER CONTENTS";
$MSG_5234 = "Insert New Category";
$MSG_5235 = "<b>Note</b>: only categories with no FAQs can be deleted.";
$MSG_5236 = "CATEGORY";
$MSG_5237 = "CAT. ID";
$MSG_5238 = "FAQ's category";
$MSG_5239 = "Question";
$MSG_5240 = "Answer<br />(HTML allowed)";
$MSG_5241 = "Edit FAQ";
$MSG_5242 = "Close";
$MSG_5243 = "Help Index";
$MSG_5244 = "AUCTIONS MANAGEMENT";
$MSG_5245 = "Top";
$MSG_5246 = "Page";
$MSG_5247 = "of";
$MSG_5248 = "Invoice Settings";
$MSG_5249 = "Sent invoices";
$MSG_5249_2 = "Feedback";
$MSG_5250 = "Archive invoices";
$MSG_5251 = "Send Invoices";
$MSG_5252 = "Invoice settings updated";
$MSG_5253 = "Tax Percentage";
$MSG_5254 = "If you need to apply your country's taxes to the invoices you send, set the value below. It will apply to every invoice you send.<br /><b>Enter 0 (zero) if you do not need to apply any tax.</b>";
$MSG_5255 = "Sign Up Fee";
$MSG_5256 = "Seller Initial Value Fee";
$MSG_5257 = "Seller Final Value Fee";
$MSG_5258 = "Buyer Final Value Fee";
$MSG_5259 = "Picture Gallery Fee";
$MSG_5260 = "Home Page Featured Item Fee";
$MSG_5261 = "Bold Item Fee";
$MSG_5262 = "Highlighted Item Fee";
$MSG_5263 = "Enable Invoicing Support?";
$MSG_5264 = "";
$MSG_5265 = "There are ";
$MSG_5266 = " pending invoice(s) to send.<br /><br />Please click on the <b>Send Now &gt;&gt;</b> button below to send them.<br />This process may take a while, wait until you receive the confirmation message. ";
$MSG_5267 = "Send now &gt;&gt; ";
$MSG_5268 = "User sign up settings";
$MSG_5269 = "You have the ability to request from your users their credit card information during the sign up process.<br />
This is an additional measure you can take. The credit card information will not be checked against a real time credit card network: only a validation algorithm will be applied.
<br /><b>Note:</b> This option is only available if <a HREF=https.php>SSL support</a> is enabled.<br /><br />SSL support is now:";
$MSG_5270 = "Request users' credit card information?";
$MSG_5271 = "User sign up settings updated";
$MSG_5272 = "Your credit card information";
$MSG_5273 = "Please provide your credit card data below.<br />A valid credit card number is required only for sign up purposes and will never be used to charge any of the fees due for the use of this site.";
$MSG_5274 = "<FONT COLOR=red><b>Enabled</b></FONT>";
$MSG_5275 = "<FONT COLOR=red><b>Disabled</b></FONT>";
$MSG_5276 = "Delete Message";
$MSG_5277 = "Back to Messages List";
$MSG_5278 = "Edit Message";
$MSG_5279 = "Back to messages list";
$MSG_5280 = "Years/Months";
$MSG_5281 = "Historical Report";
$MSG_5282 = "View current month";
$MSG_5283 = "Edit FAQs Category";
$MSG_5284 = "Category Name";
$MSG_5285 = "Credit card number";
$MSG_5286 = "Expiration date";
$MSG_5287 = "Card owner";
$MSG_5288 = "mm/yy";
$MSG_5289 = "CC";
$MSG_5290 = "Status";
$MSG_5291 = "Active users";
$MSG_5292 = "Account never confirmed";
$MSG_5293 = "Sign up fee not paid";
$MSG_5294 = "Suspended by the admin";
$MSG_5295 = "View";
$MSG_5296 = "All users";
$MSG_5297 = "User Credit Card Information";
$MSG_5298 = "Https must be enabled to retrieve<br />users credit card information.";
$MSG_5299 = "Limit submission to";
$MSG_5300 = " messages sent.";
$MSG_5301 = "Card ZIP/Post code";
// // -----------------------------------------------
$MSG_5302 = "Total";
$MSG_5303 = "Taxes";
$MSG_5304 = "Grand Total";
$MSG_5305 = "Invoice sent";
$MSG_5306 = "Invoices sent";
$MSG_5307 = "Invoice #";
$MSG_5308 = "Date";
$MSG_5309 = "Customer";
$MSG_5310 = "Total";
$MSG_5311 = "Invoices in the database";
$MSG_5312 = "Invoice details";
$MSG_5313 = "Taxes";
$MSG_5314 = "Grand Total";
$MSG_5315 = "Export to text";
$MSG_5316 = "Back to invoices &gt;&gt;";
$MSG_5317 = "Back to users list &gt;&gt;";
$MSG_5318 = "View Platform Statistics";
$MSG_5319 = "Invoice copy to the admin";
$MSG_5320 = "Select <b>Yes</b> if you want a copy of the invoices to be sent to the admin e-mail address.";
$MSG_5321 = "You can customize your invoices editing the following files:<UL>
<LI>includes/invoice_header_text.inc.txt
<LI>includes/invoice_footer_text.inc.txt
</UL>
which are appended at the top and the bottom of each invoice respectively.
";
$MSG_5322 = "Default country";
$MSG_5321 = "You can select a default country for your site.<br />It will automatically appear as the selected country in the countries select box throughout the site.";
$MSG_5323 = "Default country updated";
$MSG_5324 = "Category Featured Items";
$MSG_5325 = "Activate this option if you want your sellers to be able to create their auctions as <b><I>Category Featured</I></b>.<br />
Category Featured Auctions appear (randomly) in the category page they belong to, according to the settings in the <a HREF=homepage.php>General Layout
Settings</a>.<br />
Don't forget to <a HREF=categoryfeaturedfee.php>set up a fee</a> for this option.";
$MSG_5326 = "Activate Category Featured Items?";
$MSG_5327 = "Category Featured";
$MSG_5328 = "Category Featured Items Option Updated";
$MSG_5329 = "This is the number of featured items to show in the Categories Pages (NOTE: ONLY <b>featured</b> items will be displayed).<br />0
(zero) is permitted.";
$MSG_5330 = "<b>NOTE: Category Featured Items are shown in the home page, in rows of four auctions wide, so this number should be an even number.</b>";
$MSG_5331 = "Category Featured Items Fee";
$MSG_5332 = "Category Featured Items Option is: ";
$MSG_5333 = "Category Featured Items Fee Updated";
$MSG_5334 = "Home Page Featured Items Fee Updated";
$MSG_5335 = "Highlighted Items Fee Updated";
$MSG_5336 = "Bold Items Fee Updated";
$MSG_5337 = "Category Featured Item";
$MSG_5338 = "Your item will randomly appear in the relative category page.";

$MSG_5340 = "Test Mode";
$MSG_5341 = "Live Mode";
$MSG_5342 = "Featured Items";
$MSG_5343 = "System Check";
$MSG_5344 = "MySQL";
$MSG_5345 = "Settings";
$MSG_5346 = "Creating conf. files";
$MSG_5347 = "Creating DB";
$MSG_5348 = "System check successful.";
$MSG_5349 = "Continue &gt;&gt;";
$MSG_5350 = "Operating System";
$MSG_5351 = "Check files";
$MSG_5352 = "Check directories";
$MSG_5353 = "Getting path";
$MSG_5356 = "Performing pre-installation checks...";
$MSG_5357 = "Error!";
$MSG_5358 = "Create a new database";
$MSG_5359 = "Use an existing database";
$MSG_5360 = "Database choice";
$MSG_5361 = "MySQL Host";
$MSG_5362 = "Database name";
$MSG_5363 = "MySQL user";
$MSG_5364 = "MySQL password";
$MSG_5365 = "Include path";
$MSG_5366 = "This must be the absolute path to your <b>includes</b> directory.<br />
If you didn't move the <b>includes</b> directory under a different name, leave the default value unchanged.";
$MSG_5367 = "Upload directory";
$MSG_5368 = "This must be the absolute path to your <b>uploaded</b> directory.<br />
If you didn't move the <b>uploaded</b> directory under a different name, leave the default value unchanged.";
$MSG_5370 = "Max. upload size";
$MSG_5371 = "This is max size of images which are uploaded to server.";
$MSG_5372 = "MD5 prefix";
$MSG_5373 = "Enter a random unpredictable long string here.<br /> It will be used to improve passwords encryption.";
$MSG_5374 = "Activate test mode?";
$MSG_5376 = "Processing configuration files";
$MSG_5377 = "Settings written to includes/config.inc.php";
$MSG_5378 = "MySQL settings written to includes/passwd.inc.php";
$MSG_5379 = ": database created";
$MSG_5380 = "Database tables created";


$MSG_5382 = "E-MAIL MESSAGES";
$MSG_5383 = "Sign up confirmation e-mail messages";
$MSG_5384 = "Auction set up confirmation e-mail messages";
$MSG_5385 = "End auction (seller)";
$MSG_5386 = "End auction (winner)";
$MSG_5388 = "Custom Tags";
$MSG_5389 = "Tag";
$MSG_5390 = "Description";
$MSG_5391 = "Select";
$MSG_5392 = "You can use the tags below in your e-mail messages texts to add custom contents.";
$MSG_5393 = "No fee set";
$MSG_5394 = "Fee set - Pay mode";
$MSG_5395 = "Fee set - Prepaymode";
$MSG_5396 = "Warning!";
$MSG_5397 = "E-mails settings";
$MSG_5398 = "Sign up fee e-mail messages";
$MSG_5400 = "Auction confirmation";
$MSG_5401 = "Auction fee confirmation";
$MSG_5402 = "Your site's name";
$MSG_5403 = "Your site's URL";
$MSG_5404 = "Admin e-mail address";

$MSG_5406 = "This is the complete URL of your site (i.e. http://www.yourdomain.com/). <b>Note: the ending slash is required</b>.";
$MSG_5407 = "This is the e-mail address of the site's administrator.";
$MSG_5408 = "Max. ";
$MSG_5409 = "TEST MODE";

$MSG_5412 = "Test Mode";
$MSG_5413 = "Live Mode";
$MSG_5414 = "GETTING HELP";
$MSG_5418 = "Contact the support team";
$MSG_5419 = "Installation";

$MSG_5431 = "Send me a new password";
$MSG_5432 = "SETTINGS";
$MSG_5433 = "Custom Settings";
$MSG_5434 = "INVOICES";
$MSG_5435 = "Wap";
$MSG_5436 = "Tools";

$MSG_5438 = "Platform Statistics for ";
$MSG_5439 = "LIVE SUPPORT";
$MSG_5440 = "Chat support is also available.";
$MSG_5442 = "Invoice limit";
$MSG_5443 = "Only invoices with total amounts due equal to or greater than the <b>Invoice limit</b> will be sent.";
$MSG_5444 = "Alternative payments";
$MSG_5445 = "You have the option to provide your users as many alternative payment methods as you need.<br /><br />
Provide below a name for each alternative method and a complete description (i.e. if you are going to get paid via wire transfer you should provide your bank account information).";
$MSG_5446 = "Short Name";
$MSG_5447 = "Detailed Description";
$MSG_5449 = "New Payment Method";
$MSG_5450 = "Payment Method Settings Updated";
$MSG_5451 = "Pending Invoices";
$MSG_5452 = " unsent invoices";
$MSG_5453 = "SEND";
$MSG_5454 = "Total (taxes included)";
$MSG_5456 = "Invoice header and footer";
$MSG_5457 = "INVOICES MANAGEMENT";

$MSG_5459 = "Invoice header";
$MSG_5460 = "Invoice footer";
$MSG_5461 = "Fees due";
$MSG_5462 = "Fee description";
$MSG_5463 = "fees found";
$MSG_5463 = "% of the initial price";
$MSG_5464 = "Preview";
$MSG_5465 = "The set up fee you will have to pay for this auction is: ";
$MSG_5466 = "You will receive periodical invoices and will have to pay the collected fees using one of the following payment methods: ";
$MSG_5467 = "Invoices received";
$MSG_5468 = "Note: only invoices whose amount is equal to or greater than ";
$MSG_5469 = " will be sent, according to the limit you set in the <a HREF=taxsettings.php>invoicing settings</a>.";
$MSG_5470 = "Paid";
$MSG_5471 = "Pay now";
$MSG_5472 = "All invoices";
$MSG_5473 = "Paid invoices";
$MSG_5474 = "Unpaid invoices";
$MSG_5475 = "View";
$MSG_5476 = "Pay Invoice";
$MSG_5477 = "You can pay using one of the following methods:";
$MSG_5478 = "Click if you have fixed the problems above ";
// // Added by Gian - nov. 9 - 2002
$MSG_5480 = "STATUS";
$MSG_5481 = "File permissions error: file is not writable.";
$MSG_5482 = "File is writable.";
$MSG_5483 = "RUN UPDATE";
$MSG_5484 = "Upgrades";
$MSG_5485 = "Patches and Updates";
// // Added by Gian - nov. 27 2002
$MSG_5486 = "Initial bonus discount";
$MSG_5487 = "You can add bonus credits to your users' accounts at
registration time. This will appear as a negative amount in their first
invoice.<br />Please enter below the bonus amount or enter zero (no
discount will be applied)";
$MSG_5488 = "Edit Pending Invoices";
$MSG_5489 = "Add New Line";
$MSG_5490 = " sent invoices";
// // Added by Gian - Dec. 7th 2002
$MSG_5491 = "Re-send";
// // Added by Gian - Jan. 30 2003
$MSG_5492 = "items";
$MSG_5493 = "bid";
$MSG_5494 = "bidded for ";
$MSG_5495 = "for each ";
$MSG_5496 = "Fees payed";
$MSG_5497 = "Main Path";
$MSG_5498 = "This must be the absolute path to your <b>main installation</b> directory.";
$MSG_5505 = "Feedback: ";
$MSG_5506 = "Positive feedback: ";
$MSG_5507 = "<font color=red>Negative feedback: </font>";
$MSG_5508 = "Member since ";
$MSG_5509 = "Feedback times ";
// // Messages used for the wap front end
$MSG_9000 = "Last created";
$MSG_9001 = "Next Ending";
$MSG_9002 = "Title: ";
$MSG_9003 = "Staring at: ";
$MSG_9004 = "Current bid: ";
// //Added for reserve price fee
$MSG_9005 = "Reserve Price Fee&nbsp;";
$MSG_9006 = "<b> % of the Reserve price </b>";
$MSG_9007 = "Reserve Price Fee";
$MSG_9009 = "Activate Reserve Price Fee?";
$MSG_9010 = "You may find the category id <a HREF=\"Javascript:window_open('catids.php','catids',400,500,20,20)\">here</a>.";
$MSG_9011 = "Reserve Fee settings updated";

// // Added by Gian Feb 13, 2003
$MSG__0001 = "Under Maintenance Page";
$MSG__0002 = "You can temporary disable the access to your site if necessary.<br />
In Maintenance mode only one user will have access to it. After you registered a user via <a TARGET=_new HREF=../register.php>the usual users registration page</a>
, insert below the username. After switching the site to Maintenance mode <a TARGET=_new HREF=../user_login.php>login here</a> to access the site.<br />
The \"Under Maintenance\" text is usually a custom HTML page (enter the HTML code below).";
$MSG__0003 = "Username";
$MSG__0004 = "Under Maintenance HTML code";
$MSG__0005 = "Under Maintenance settings updated";
$MSG__0006 = "Switch site to \"Under Maintenance\" mode?";
$MSG__0007 = "The code";
$MSG__0008 = "Banners Administration";
$MSG__0010 = "BANNERS";
$MSG__0011 = "Enable/Disable";
$MSG__0012 = "Users Management";
$MSG__0013 = "Banner Related Settings";
$MSG__0015 = "Any size";
$MSG__0016 = "Fixed size (please specify)";
$MSG__0017 = "Width";
$MSG__0018 = "Height";
$MSG__0019 = "pixels";
$MSG__0020 = "Width and height must be integer numbers";
$MSG__0021 = "User";
$MSG__0022 = "Company";
$MSG__0023 = "E-mail";
$MSG__0024 = "Manage Banners";
$MSG__0025 = "Banners";
$MSG__0026 = "Add user";
$MSG__0027 = "Back";
$MSG__0028 = "Delete selected (banners will be deleted)";
$MSG__0029 = "Select banner";
$MSG__0030 = "URL";
$MSG__0031 = "Text under banner";
$MSG__0032 = "ALT text";
$MSG__0033 = "<b>Filters</b>";
$MSG__0034 = "Categories";
$MSG__0035 = "Keywords";
$MSG__0036 = "Accepted formats: GIF, JPG, PNG, SWF";
$MSG__0037 = "Complete URL including http://";
$MSG__0038 = "Can be left blank";
$MSG__0039 = "You have the ability to filter the banners rotations with two different criterias:
<UL>
<LI><b>Categories</b>: select below one or more categories. The banner will appear only when the selected categories are visible (i.e. browsing categories, auction page)
<LI><b>Keywords</b>: enter one or more keywords (one per line). The banner will only appear in those auctions page where at least one keyword is contained in the item's title or description
</UL>
The <b>Categories</b> filter will be applied in the browse categories pages and in the items' pages.<br />
The <b>Keywords</b> filter will be only applied in the auctions page.<br />
If none of the filters applied match, a random banner (among those with no filters associated) will be shown.";
$MSG__0040 = "Add banner";
$MSG__0041 = "<b>New banner</b>";
$MSG__0042 = "&nbsp;(required)";
$MSG__0043 = "<b>User Banners</b>";
$MSG__0044 = "Please insert a valid URL";
$MSG__0045 = "Views purchased";
$MSG__0046 = "Zero or blank means unlimited views";
$MSG__0047 = "$TARGET already exists";
$MSG__0048 = "Wrong file type. Allowed formats: GIF, JPG, PNG, SWF";
$MSG__0049 = "Views:";
$MSG__0050 = "URL:";
$MSG__0051 = "Clicks:";
$MSG__0052 = "View&nbsp;filters";
$MSG__0053 = "<b>Categories</b>";
$MSG__0054 = "<b>Keywords</b>";
$MSG__0055 = "Edit Banner";
$MSG__0056 = "New banner";
// // Added April 2003 for Aboutme page
$MSG__0100 = "About me page";
$MSG__0101 = "Activate About Me page support?";
$MSG__0102 = "You can enable or disable About Me page support for your sellers and buyers.
<BR /><B>Note:</B> Be sure to <A HREF=aboutmetemplates.php>add the HTML templates</A> otherwise your users will not be able to use this feature.";

$MSG__0104 = "UPDATE SETTINGS TABLE";
$MSG__0105 = "About Me Settings Updated";
$MSG__0106 = "Enable/Disable";
$MSG__0107 = "About me Templates";
$MSG__0108 = "You can add, modify or delete templates below.<br />Page templates must contain the tags to be replaced with the users data.<br />
<a HREF=\"Javascript:window_open('viewtemplatetags.html','catids',400,500,20,20)\">Click here for a list of tags</a>.
<br />There are two simple (graphically poor) sample templates in the admin directory:
<UL>
<LI>aboutmetemplate1.html
<LI>aboutmetemplate2.html
</UL>";
$MSG__0109 = "Current templates";
$MSG__0110 = "Template name";
$MSG__0111 = "Edit";
$MSG__0112 = "View";
$MSG__0113 = "Add template";
$MSG__0114 = "Add now";
$MSG__0115 = "Template HTML code";
$MSG__0116 = "DELETE";
$MSG__0117 = "Delete selected templates";
$MSG__0118 = "New template added to the database";
$MSG__0119 = "Edit About me template";
$MSG__0120 = "Database updated";
$MSG__0121 = "About me";
$MSG__0122 = "Sample image";
$MSG__0123 = "The file ";
$MSG__0124 = " already exists.";
$MSG__0125 = "The image width should be 250 pixels. If bigger it will be forced to 250 pixels.";
$MSG__0126 = "New sample image";
$MSG__0127 = "We noticed you have never created your <I>About me</I> page. Please enter your data below and hit the <b>Preview</b> button to see how your page will look like.<br />
When it's ready, hit the <b>Publish</b> button to make it public.<br /> <FONT SIZE=+1 COLOR=RED><b>*</b></FONT> means required field";
$MSG__0128 = "Select the page template";
$MSG__0129 = "Enter the page contents";
$MSG__0130 = "No sample image available";
$MSG__0131 = "Page title";
$MSG__0132 = "Welcome message";
$MSG__0133 = "Heading";
$MSG__0134 = "Message body";
$MSG__0135 = "Heading";
$MSG__0136 = "Additional paragraph";
$MSG__0137 = "Your auctions";
$MSG__0138 = "Picture";
$MSG__0139 = "Number of your active auctions to show (oldest will show first). Enter zero or leave blank if you don't want to show your items in your <I>About me</I> page.";
$MSG__0140 = "Preview";
$MSG__0141 = "Publish";
$MSG__0142 = "You must select a page template";
$MSG__0143 = "<FONT SIZE=+1 COLOR=RED><b>*</b></FONT>";
$MSG__0144 = "The number of auctions must be numeric";
$MSG__0145 = "Back";
$MSG__0146 = "Edit your <I>About me</I> page";
$MSG__0147 = "Edit your <I>About me </I> page data below. The modified page will not be visible until you hit the <b>Publish</b> button.<br /><FONT SIZE=+1 COLOR=RED><b>*</b></FONT> means required field";
$MSG__0148 = "Auction relisting";
$MSG__0149 = "Invalid relisting value: must be a number";
$MSG__0150 = "Item will be automatically relisted ";
$MSG__0151 = " times";
$MSG__0152 = "No relisting option set";
$MSG__0153 = "Relists / <br />Relisted";
$MSG__0154 = "Relisted ";
$MSG__0155 = " times.";
$MSG__0156 = "Auctions relisting settings";
$MSG__0157 = "Sellers will have the ability to set the number of times they want their auctions relisted, if no bids are placed.
Limit the maximum number of times an auction can be relisted below.<br />
Enter zero or leave the field blank if you don't want to enable this feature.";
$MSG__0158 = "Relisting limit";
$MSG__0159 = "Incorrect relisting limit";
$MSG__0160 = "Relisting settings updated";
$MSG__0161 = "Maximum number of scheduled relistings exceeded. ";
$MSG__0162 = "You can choose to automatically relist your auction, if no bids have been posted.<br />
Enter the number of times you want your auction to be relisted (enter zero or leave blank if you don't want the automatic relisting to be applied to this auction).
<br /><FONT COLOR=RED>Maximum numer of allowed relistings: ";
// // Added May 26, 2003
$MSG__0163 = "Winners";
$MSG__0164 = "Invalid auction ID";
$MSG__0165 = "The specified auction does not exist";
$MSG__0166 = "Wiew winners";
/**
* NOTE: added aug. 19, 2003
*/
$MSG__0167 = "Manually relisted";
$MSG__0168 = "Manually relisted auctions";
$MSG__0169 = "Back &gt;&gt;";
/**
* NOTE: GPL 2.0
*/
$MSG_2_0001 = "Classifieds";
$MSG_2_0002 = "Export list to Excel file";
// // IP BANNING MANAGEMENT
$MSG_2_0003 = "IPs MANAGEMENT";
$MSG_2_0004 = "View User's IPs";
$MSG_2_0005 = "Sign up IP";
$MSG_2_0006 = "Ban";
$MSG_2_0007 = "Accept";
$MSG_2_0008 = "Description";
$MSG_2_0009 = "IP Address";
$MSG_2_0010 = "Status";
$MSG_2_0011 = "Action";
$MSG_2_0012 = "<FONT COLOR=GREEN><b>Accepted</b></FONT>";
$MSG_2_0013 = "<FONT COLOR=red><b>Banned</b></FONT>";
$MSG_2_0014 = "User login";
$MSG_2_0015 = "Process Selection";
$MSG_2_0016 = "User: ";
$MSG_2_0017 = "IP Addresses";
$MSG_2_0018 = "IP ADDRESS SEARCH";
$MSG_2_0019 = "Enter the complete IP address or a part of it.<br />
Examples:<UL><LI>215.25.0.55<LI>225.76<LI>36.52.125</UL>";
$MSG_2_0020 = "Banned IP Addresses Management";
$MSG_2_0021 = "Ban this IP address: ";
$MSG_2_0022 = "Delete";
$MSG_2_0024 = "(Complete IP address - example: 185.39.51.63)";
$MSG_2_0025 = "Automatically entered";
$MSG_2_0026 = "We're sorry but, for one or more reasons, you have been denied access to
this site.<br />
If you had any active auctions listed, we have cancelled all bids and
removed the item(s) from our database.
<br /><br />
Thank you";
$MSG_2_0027 = "Feedback Left?";
// // Added by Gian on Aug. 5 - 2003
$MSG_2_0028 = "Winning Bidder?";
$MSG_2_0029 = "Invoice";
$MSG_2_0030 = "You can request an invoice for all or some of the fees listed below by selecting the checkbox in
the <b>Invoice</b> column and clicking on the <b>Create invoice</b> button.
<br />The invoice will be automatically created and sent to your e-mail address.
<br />It will also be available in the <a HREF=yourinvoices.php>Invoices received</a> page in your control panel.";
$MSG_2_0031 = "Create invoice";
// // AUCTIONS AUOEXTENSION
$MSG_2_0032 = "Auction Extension Settings";
$MSG_2_0033 = "AUCTIONS EXTENSION";
$MSG_2_0034 = "Enable Auctions Autoextension?";
$_CUSTOM_0032 = "Auctions Autoextension gives you the ability to automatically extend by <b>X</b> seconds the auctions end time,
if someone bids in the last <b>Y</b> seconds of the auction lifetime.
<br />";
$MSG_2_0035 = "Extend auction by ";
$MSG_2_0036 = " seconds if someone bid during the last ";
$MSG_2_0037 = " seconds";
$MSG_2_0038 = "Please enter valid numeric values";
$MSG_2_0039 = "Auction Autoextension Settings Updated";
// // Added by Gian for fee ranges
$MSG_2_0040 = "Enable/Disable";
$MSG_2_0041 = "Set Values";
$MSG_2_0042 = "Seller's Final Value Fee";
$MSG_2_0043 = "From";
$MSG_2_0044 = "To";
$MSG_2_0045 = "Value";
$MSG_2_0046 = "Delete";
$MSG_2_0047 = "Reverse Auctions";
// //
$MGS_2__0001 = "Choose language";
$MGS_2__0002 = "Multilingual support";
$MGS_2__0004 = "Default language";
$MGS_2__0005 = "<FONT COLOR=RED><b>Current default language</b></FONT>";
$MGS_2__0006 = "Fee type";
$MGS_2__0007 = "%";
$MGS_2__0008 = "Fixed amount";
$MGS_2__0009 = "Enter the amount ranges below and the corresponding fee for each one.<br />
For example:
<TABLE WIDTH=100% CELLPADDING=2 BGCOLOR=\"#FFFFFF\">
  <TR>
    <TD WIDTH=\"132\" BGCOLOR=\"#EEEEEE\"> <b> From </b> </TD>
    <TD WIDTH=\"132\" BGCOLOR=\"#EEEEEE\"><b> To </b> </TD>
    <TD WIDTH=\"132\" BGCOLOR=\"#EEEEEE\"><b> Value </b> </TD>
    <TD WIDTH=\"96\" BGCOLOR=\"#eeeeee\"> <b> Fee type </b></TD>
  </TR>
  <TR BGCOLOR=\"#FFFFFF\">
    <TD><FONT SIZE=\"2\" FACE=\"Verdana, Arial, Helvetica, sans-serif\">0.00</FONT></TD>
    <TD><FONT SIZE=\"2\" FACE=\"Verdana, Arial, Helvetica, sans-serif\">100.00</FONT></TD>
    <TD><FONT SIZE=\"2\" FACE=\"Verdana, Arial, Helvetica, sans-serif\">1.00</FONT></TD>
    <TD><FONT SIZE=\"2\" FACE=\"Verdana, Arial, Helvetica, sans-serif\">Fixed amount</FONT></TD>
  </TR>
  <TR BGCOLOR=\"#FFFFFF\">
    <TD><FONT SIZE=\"2\" FACE=\"Verdana, Arial, Helvetica, sans-serif\">101.00</FONT></TD>
    <TD><FONT SIZE=\"2\" FACE=\"Verdana, Arial, Helvetica, sans-serif\">200.00</FONT></TD>
    <TD><FONT SIZE=\"2\" FACE=\"Verdana, Arial, Helvetica, sans-serif\">1.50</FONT></TD>
    <TD><FONT SIZE=\"2\" FACE=\"Verdana, Arial, Helvetica, sans-serif\">Fixed amount</FONT></TD>
  </TR>
  <TR BGCOLOR=\"#FFFFFF\">
    <TD><FONT SIZE=\"2\" FACE=\"Verdana, Arial, Helvetica, sans-serif\">201.00</FONT></TD>
    <TD><FONT SIZE=\"2\" FACE=\"Verdana, Arial, Helvetica, sans-serif\">500.00</FONT></TD>
    <TD><FONT SIZE=\"2\" FACE=\"Verdana, Arial, Helvetica, sans-serif\">3.00</FONT></TD>
    <TD><FONT SIZE=\"2\" FACE=\"Verdana, Arial, Helvetica, sans-serif\">%</FONT></TD>
  </TR>
  <TR BGCOLOR=\"#FFFFFF\">
    <TD><FONT SIZE=\"2\" FACE=\"Verdana, Arial, Helvetica, sans-serif\">501</FONT></TD>
    <TD><FONT SIZE=\"2\" FACE=\"Verdana, Arial, Helvetica, sans-serif\">10000000000</FONT></TD>
    <TD><FONT SIZE=\"2\" FACE=\"Verdana, Arial, Helvetica, sans-serif\">5</FONT></TD>
    <TD><FONT SIZE=\"2\" FACE=\"Verdana, Arial, Helvetica, sans-serif\">%</FONT></TD>
  </TR>
  <TR>
    <TD> </TD>
  </TR>
</TABLE>";
$MGS_2__0010 = "<br /><br /><b>Note:</b> The best way to run cron.php is to use a cronjob.
The <b>non-batch</b> mode is not recommended: problems have been reported when used on trafficated sites.";
$MGS_2__0011 = "This tool is available only if no auctions are present in the database.";
$MGS_2__0012 = "The payment methods defined below are the payment methods accepted by sellers to receive money from buyers.";
$MGS_2__0013 = "ID";
$MGS_2__0014 = "Quantity";
$MGS_2__0015 = "Seller";
$MGS_2__0016 = "Starting date";
$MGS_2__0017 = "Duration";
$MGS_2__0018 = "Ending date";
$MGS_2__0019 = "Starting bid";
$MGS_2__0020 = "Current bid";
$MGS_2__0021 = "# of bids";
$MGS_2__0022 = "Relist (Relisted)";
$MGS_2__0023 = "Auction type";
$MGS_2__0024 = "Reserve price";
$MGS_2__0025 = "Buy it now";
$MGS_2__0026 = "Private";
$MGS_2__0027 = "ALL";
$MGS_2__0028 = "Browse pages";
$MGS_2__0029 = "Invalid invoice number";
$MGS_2__0030 = " means the entry cannot be deleted because it's in use.";
$MGS_2__0031 = "Note that if you enable the invoicing system the <a HREF=admin.php?S=fees>Pay and Prepay</a> options will not have any effect.";
$MGS_2__0032 = "Bidfind support";
$MGS_2__0033 = "Bidfind support will give you visibility through the bidfind searchable directory
(<a HREF=http://bidfind.com/af/af-allcat.html TARGET=_blank>http://bidfind.com/af/af-allcat.html</a>).
<br />To get listed at bidfind go to their <a HREF=http://bidfind.com/af/af-sitereg.html TARGET=_blank>Get Your Site Listed</a> page and follow the necessary steps.
<br />Enable bidfind below to periodically generate the <I>megalist</I> file (megalist.html).";
$MGS_2__0034 = "Enable Bidfind support?";
$MGS_2__0035 = "Bidfind settings updated.";
$MGS_2__0036 = "Buy it now";
$MGS_2__0037 = "Submit auction";
$MGS_2__0038 = "Select your category";
$MGS_2__0039 = "If you've forgotten your password, just enter your email below and we'll send you a new one.";
$MGS_2__0040 = "Email address";
$MGS_2__0041 = "Winning Bid";
$MGS_2__0042 = "Thumbnails";
$MGS_2__0044 = "Thumbnails width";
$MGS_2__0045 = " pixels ";
$MGS_2__0046 = "Thumbnails Settings Updated";
$MGS_2__0047 = "SELECT CATEGORY &gt;&gt;";
$MGS_2__0048 = "Close Now!";
$MGS_2__0049 = "Relist now!";
$MGS_2__0050 = "Relist auction";
$MGS_2__0051 = "Page Width";
$MGS_2__0052 = "This is the width of most external box in your site pages. Can be expressed in pixels or as a percentage of the browser's window.";
$MGS_2__0053 = "pixels";
$MGS_2__0054 = "<b><FONT COLOR=red>Already selected</FONT></b>";
$MGS_2__0055 = "For your changes to take effect you must proceed to pay the fees below.
<br /><FONT COLOR=RED><b>Note: if you do not proceed to pay the fees now, your auction will remain suspended and will not be visible to bidders</b></FONT>";
$MGS_2__0056 = "Suspended auctions";
$MGS_2__0057 = "Show counters";
$MGS_2__0058 = "You can decide to show some counters in the header of your site's pages.<br />
There are three different counters available:
<UL>
<LI>Active auctions
<LI>Registered users
<LI>Online users
</UL>
You can enable/disable each counter below";
$MGS_2__0059 = "Online users";
$MGS_2__0060 = "Active auctions";
$MGS_2__0061 = "Registered users";
$MGS_2__0062 = "Counters you want to show";
$MGS_2__0063 = "Counters Settings Updated";
$MGS_2__0064 = "USERS ONLINE";
$MGS_2__0065 = "<b>Note</b>: the automatic auctions relisting options is only available if <a HREF=taxsettings.php>Invoicing is enabled</a>.
<br />Invoicing is now: ";
$MGS_2__0066 = "Enabled";
$MGS_2__0067 = "Disabled";
$MGS_2__0068 = "For automatic relisting";
$MGS_2__0069 = "Edited in this session.";
$MGS_2__0070 = "<FONT COLOR=ORANGE><b>Alerady added in this same session: not yet payed</b></FONT>";
$MGS_2__0071 = "This option is only available if no auctions (active or closed) are present in the database";
$MGS_2__0072 = "Charge Seller's Setup Fee?";
$MGS_2__0073 = "You can choose to charge or not charge the Seller's Setup Fee when an auction is automatically relisted.
The featured Options Fees will always be charged.";
$MGS_2__0074 = "The following auctions have been rellisted.";
$MGS_2__0075 = "Auction Title";
$MGS_2__0076 = "Total Fees Charged";
$MGS_2__0077 = "You can choose to charge or not charge the Seller's Setup Fee when an auction is manually relisted.
The featured Options Fees will always be charged.";
$MSG_2__0078 = ": database updated";
$MSG_2__0079 = "Database tables created, or updated where necessary";
$MSG_2__0080 = "Your Country Tax NAME (e.g TVA)";

$MSG_2__0081 = "If you were coming from bulk uploaded auctions and want to come back,";
$MSG_2__0082 = "CLICK HERE";
$MSG_2__0083 = "If you were coming from closed auctions and want to come back,";
$MSG_2__0084 = "uploaded";
$MSG_2__0085 = "If you were coming from active auctions and want to come back,";

$ERR_25_0000 = "Reserve price must be greater than minimum bid, and buy now must be greater than reserve price.";
$ERR_25_0001 = "Please choose a sub-category";

$MSG_25_0000 = "Your Sell Defaults";
$MSG_25_0001 = "WINNER";
$MSG_25_0002 = "SELLER";
$MSG_25_0003 = "Leave feedback";
$MSG_25_0004 = "User name";
$MSG_25_0005 = "E-mail";
$MSG_25_0006 = "Final bid";
$MSG_25_0007 = "Settings";
$MSG_25_0008 = "Preferences";
$MSG_25_0009 = "Graphic Interface";
$MSG_25_0010 = "Users";
$MSG_25_0011 = "Advertisement";
$MSG_25_0012 = "Search Users";
$MSG_25_0013 = "User Account";
$MSG_25_0014 = "Ban";
$MSG_25_0015 = "Send Newsletter";
$MSG_25_0016 = "Featured Options";
$MSG_25_0017 = "Suspend Auction";
$MSG_25_0018 = "Contents";
$MSG_25_0019 = "Help";
$MSG_25_0020 = "Fees";
$MSG_25_0021 = "Invoices";
$MSG_25_0022 = "Pay/Prepay Mode";
$MSG_25_0023 = "Statistics";
$MSG_25_0024 = "<br /><CENTER><b>Warning: your installation script is still present in the \"admin\" directory.<br />
			   For security reasons you'd better delete it or move it elsewhere.<B/>
			   </CENTER><br /><br />";
$MSG_25_0025 = "Installation Status";
$MSG_25_0026 = "Batch Process (cron.php)";
$MSG_25_0028 = "Paypal E-mail Address";
$MSG_25_0029 = "IPN URL: ";
$MSG_25_0030 = "<FONT COLOR=RED>Paypal address missing!</FONT> [<a HREF=paypaladdress.php>Fix</a>]";
$MSG_25_0031 = "Statistical Resume";
$MSG_25_0032 = "Maximum number of automatic relistings allowed: ";
$MSG_25_0033 = "No automatic relistings allowed";
$MSG_25_0034 = "<FONT COLOR=RED>Invoices are disabled, it must be enable for the auctions relisting to have affect</FONT> [<a HREF=taxsettings.php>Fix</a>]";
$MSG_25_0035 = "Time Correction";
$MSG_25_0036 = "Server Time";
$MSG_25_0037 = " hours";
$MSG_25_0038 = "Counters shown in the header:<br />";
$MSG_25_0039 = "Available Languages";
$MSG_25_0040 = "Pages Alignment";
$MSG_25_0041 = "Shown on Home Page";
$MSG_25_0042 = "Login Box";
$MSG_25_0043 = "News Box";
$MSG_25_0044 = "News Shown";
$MSG_25_0045 = "Thumbnails Width";
$MSG_25_0046 = "Home Page Featured Items: ";
$MSG_25_0047 = "Category Featured Items: ";
$MSG_25_0048 = "Other thumbnails: ";
$MSG_25_0049 = "Newsletter Subscription";
$MSG_25_0050 = "Fees";
$MSG_25_0051 = "Pay";
$MSG_25_0052 = "Prepay";
$MSG_25_0053 = "<br />Pay/Prepay mode are only available and take effect if invoices are disabled.<br />
Since invoices are now enabled <a HREF=taxsettings.php>you should disable them</a> first if you are going to work in Pay or Prepay mode.";
$MSG_25_0054 = "view details";
$MSG_25_0055 = "Registered Active Users";
$MSG_25_0056 = "Registered Suspended Users";
$MSG_25_0057 = "Live Auctions";
$MSG_25_0058 = "Closed Auctions";
$MSG_25_0059 = "Bids on live auctions";
$MSG_25_0060 = "Pending Invoices Total";
$MSG_25_0061 = "Unpaid Invoices";
$MSG_25_0062 = "(taxes not included)";
$MSG_25_0063 = "Today's Accesses";
$MSG_25_0064 = "Web Stores";
$MSG_25_0065 = "Stores Definition";
$MSG_25_0066 = "Themes' Colors";
$MSG_25_0067 = "Stores Management";
$MSG_25_0068= "Variant Labels Table";
$MSG_25_0069= "Labels copied from parent directory";
$MSG_25_0070= "New value -->";
$MSG_25_0071= "Item specifications";
$MSG_25_0073= "Numeric";
$MSG_25_0074= "Resend&nbsp;e-mail";
$MSG_25_0075= "Resend Signup Confirmation E-mail";
$MSG_25_0076= "Resend E-mail";
$MSG_25_0077= "No HTML allowed";
$MSG_25_0078= "E-mail sent to ";
$MSG_25_0079= "Newsletter";
$MSG_25_0080= "select value";
$MSG_25_0081= "or in range";
$MSG_25_0080= "Summary";
$MSG_25_0081= "My Account";
$MSG_25_0082= "Selling";
$MSG_25_0083= "Buying";
$MSG_25_0084= "Add a new item keyword";
$MSG_25_0085= "Remember me";
$MSG_25_0086= "Contact us";
$MSG_25_0087= "The <b>Contact us</b> option lets you introduce staff members' names and roles along with their e-mail addresses.<br />
Users contacting you through the <a TARGET=_blank HREF=../contactus.php>contact us</a> page will be able to choose to whom the message should be forwarded.<br />
If you don't want the <b>Contactus</b> page to appear on your website, do not enter anything below.";
$MSG_25_0088= "Role";
$MSG_25_0089= "Name&nbsp;(optional)";
$MSG_25_0090= "Add";
$MSG_25_0091= "Contact from ";
$MSG_25_0092= "An error occured while sending the e-mail";
$MSG_25_0093= "Thanks for contacting us. Our staff will get in contact with you as soon as possible.";
$MSG_25_0094= "Staff's member";
$MSG_25_0095= "Send message";
$MSG_25_0096= "Users signup confirmation";
$MSG_25_0097= "If the Signup Confirmation Option is enabled, the administrator's approval is required (you will receive copy of the
e-mail sent to the user at registration).
If the option is not enabled, users will receive a signup confirmation e-mail and will need to confirm their
registration.
<br /><br />The <b>Users signup confirmation</b> option is only available if no signup fee is requested.";
$MSG_25_0098= "Enable users signup confirmation?";
$MSG_25_0099= "Signup Confirmation Settings Updated";
$MSG_25_0100= "The Signup Confirmation Settings option cannot be enabled because a signup fee is set. [<a HREF=signupfee.php>fix</a>]";
$MSG_25_0101= "Pending Confirmations";
$MSG_25_0102= "Accept";
$MSG_25_0103= "Reject";
$MSG_25_0104= "Fees Free";
$MSG_25_0105= "Save Selection";
$MSG_25_0106= "You can select one or more categories (see categories) to avoid charging the fee for auctions listed under them.<br />
This is usualy done for promotional purpose for limited period of time";
$MSG_25_0107= "Auctions Lists Thumbnails";
$MSG_25_0108= "Home Page Thumbnails";
$MSG_25_0109= "Categories Thumbnails";
$MSG_25_0110= "Acceptance Text";
$MSG_25_0111= "Acceptance Text Settings Updated";
$MSG_25_0112= "Free Categories Text";
$MSG_25_0113= "This text will appear at the top of the sell page when sellers start listing an auction under one of the free categories (HTML allowed, max. 255 characters)";
$MSG_25_0114= "Free Categories Settings Updated";
$MSG_25_0115= "Pending auctions";
$MSG_25_0116= "Will start";
$MSG_25_0117= "Will end";
$MSG_25_0118= "Start now!";
$MSG_25_0119= "Sold Items";
$MSG_25_0120= "Ban users belonging to my Banned Users List";
$MSG_25_0121= "Closed on";
$MSG_25_0122= "Account types";
$MSG_25_0124= "Different account for sellers and buyers";
$MSG_25_0125= "Unique account";
$MSG_25_0126= "Account Type Settings Updated";
$MSG_25_0127= "You selected the following accounts type: ";
$MSG_25_0128= "You can change your selection from the <a HREF=accounttypes.php>Account Types</a> page";
$MSG_25_0129= "For sellers only";
$MSG_25_0130= "For buyers only";
$MSG_25_0131= "For both buyers and sellers";
$MSG_25_0132= "No confirmation requested to buyers and sellers";
//$MSG_25_0133= "I want to register as";
$MSG_25_0133= "You will be registred as";
$MSG_25_0134= "<b>Seller</b> (can sell and bid for items)";
$MSG_25_0135= "<b>Buyer only</b> (can only bid for items)";
$MSG_25_0136= "Requires administrator's approval";
$MSG_25_0137= "You must select an account type (seller or buyer)";
$MSG_25_0138= "Sellers";
$MSG_25_0139= "Buyers";
$MSG_25_0140= "Your account is a buyer account. No selling activity is allowed.<br /> If you want to switch to a <b>seller account</b> ";
$MSG_25_0141= "send a request to the site administrator";
$MSG_25_0142= "Request sent to the site's administrator.";
$MSG_25_0143= "Your account is a buyer account. No selling activity is allowed.<br /> You already sent a request to switch to a <b>seller account</b>: your request is being processed. ";
$MSG_25_0144= "Buyers Requests";
$MSG_25_0145= "Your Account Upgrade Request";
$MSG_25_0146= "Categories Sorting";
$MSG_25_0147= "The categories list in the left column of the home page, can be sorted <b>alphabetically</b> or on the number of auctions contained in each category (<b>categories counters</b>).<br />
Choose below the sorting method you want to have";
$MSG_25_0148= "Alphabetically";
$MSG_25_0149= "Categories counters";
$MSG_25_0150= "Categories Sorting Settings Updated";
$MSG_25_0151= "Users Authentication";

$MSG_25_0153= "Default (ask for password before submitting an auction)";
$MSG_25_0154= "No user authentication";
$MSG_25_0155= "Users Authentication Settings Updated";
$MSG_25_0156= "Ranges -->";
$MSG_25_0157 = "Your background image";
$MSG_25_0158 = "Current background (reduced)";
$MSG_25_0159 = "Upload a new background (max. 50 Kbytes)";
$MSG_25_0160 = "Repeat";
$MSG_25_0161 = "Repeat horizontally";
$MSG_25_0162 = "Repeat vertically";
$MSG_25_0163 = "Single instance";
$MSG_25_0164 = "Don't use";
$MSG_25_0165 = "Options";
$MSG_25_0166 = "Back to auction";
$MSG_25_0167 = "icon";
$MSG_25_0168 = "delete";
$MSG_25_0169 = "Membership Levels";
$MSG_25_0170 = "Edit, delete or add membership levels using the form below. \"Points\" means up limit (min level is implicit), \"membership\" is the name of the level, \"icon\" is the name of the icon corresponding to the level to be displayed, relative to the \"images/icons/\" directory";
$MSG_25_0171 = "Points owed";
$MSG_25_0172 = "membership type";
$MSG_25_0173 = "discount (inactive)";
$MSG_25_0174 = "Paypal Currency";
$MSG_25_0175 = "Select the currency to use for Paypal payments (USD,GBP,JPY,CAD,EUR only)";
$MSG_25_0176 = "CONVERT NOW!";
$MSG_25_0177 = "for";
$MSG_25_0178 = "HTML meta Tags";
$MSG_25_0179 = "To help crawler-based search engines (like Google) to better expose your site, you can use the <b>Meta Description Tag</b> and the <b>Meta Keywords Tag</b>.
<br />Both will give the search engine additional information besides the one they grab from your site's pages but <b>do not expect to get a good ranking in any search engine just because of Meta Tags!</b>.
Some search engines ignore Meta Tags at all.
<br />A good article to learn more about Meta Tags can be found <a HREF=http://searchenginewatch.com/webmasters/article.php/2167931 TARGET=_blank>here</a>.
<br /><br />Leave the field(s) blank if you don't want to use Meta Tags.";
$MSG_25_0180 = "Meta Description Tag";
$MSG_25_0181 = "Meta Keywords Tag";
$MSG_25_0182 = "The Meta Description Tag is usually used to describe your pages in the search results pages search engines show.<br />
Enter the text which better describes your site below.";
$MSG_25_0184 = "The Meta Keywords Tag gives some search engines additional information to use to index your site.<br />
Enter the your keywords below separated by comas (i.e. books, books auctions, book sales).";
$MSG_25_0185 = "Meta Tags Settings Updated";
$MSG_25_0186 = "Pictures Upload";
$MSG_25_0187 = "Enter the maximum allowed size (in Kbytes) of the pictures sellers can upload for each auction.<br />
<b>Note</b>: this is the standard image associated with an auction, picture gallery settings can be changed <a HREF=picturesgallery.php>here</a>.";
$MSG_25_0188 = "Auctions notification e-mails";
$MSG_25_0189 = "As a seller, you can choose to receive one notification e-mail for each auction which closes, or to receive an e-mail once a day reporting all the closed auctions on that day.<br />
The second option is usually necessary if you have a huge number of auctions.<br />Finally you can also choose not to receive any notification e-mail but this choice is not recommended.";
$MSG_25_0190 = "Receive <b>one</b> e-mail for each closing auction";
$MSG_25_0191 = "Receive one cumulative e-mail once a day";
$MSG_25_0192 = "E-mails notification options updated";
$MSG_25_0193 = "Do not receive any e-mail";
$MSG_25_0194 = "Do not receive any e-mail";
$MSG_25_0195 = "You can choose to receive a notification e-mail for each auction you set up or to not receive it.";
$MSG_25_0196 = "Receive the <b>auction setup confirmation e-mail</b>.";
$MSG_25_0197 = "Do not Receive the <b>auction setup confirmation e-mail</b>.";
$MSG_25_0198 = "about";
$MSG_25_0199 = "Closing auctions resume";
$MSG_25_0200 = "Feedback total: ";
$MSG_25_0201 = "Reply to this feedback: ";
$MSG_25_0202 = " reply: ";
$MSG_25_0203 = " on ";
$MSG_25_0204 = "Trust/Untrust users";
$MSG_25_0205 = "Trust";
$MSG_25_0206 = "Untrust";
$MSG_25_0207 = "Trusted users";
$MSG_25_0208 = "Untrusted users";
$MSG_25_0209 = "Sell under price";
$MSG_25_0210 = " positive ";
$MSG_25_0211 = " fair ";
$MSG_25_0212 = " negative ";
$MSG_25_0213 = "Leave this comment to all selected: ";
$MSG_25_0214 = "Search also closed auctions: ";
$MSG_25_0215 = "Shipping terms";
$MSG_25_0216 = "Contact the seller";
$MSG_25_0218 = "Any visitor can contact the seller (the ability to contact the seller will be ALWAYS shown)";
$MSG_25_0219 = "Only logged in users can contact the seller (the ability to contact the seller will be shown only to other users of your site if logged in)";
$MSG_25_0220 = "Nobody can contact the seller (the ability to contact the seller will NEVER be shown)";
$MSG_25_0222 = "you save ";
$MSG_25_0223 = "Feedbacks you received";
$MSG_25_0224 = "Default sell data updated";
$MSG_25_0225 = "Edit feedback";
$MSG_25_0226 = "Number of columns in which the featured auctions will be grouped";
$MSG_25_0229 = "Pages: ";

//multi-language months
$MSG_MON_001="Jan";
$MSG_MON_001E="January";
$MSG_MON_002="Feb";
$MSG_MON_002E="February";
$MSG_MON_003="Mar";
$MSG_MON_003E="March";
$MSG_MON_004="Apr";
$MSG_MON_004E="April";
$MSG_MON_005="May";
$MSG_MON_005E="May";
$MSG_MON_006="Jun";
$MSG_MON_006E="June";
$MSG_MON_007="Jul";
$MSG_MON_007E="July";
$MSG_MON_008="Aug";
$MSG_MON_008E="August";
$MSG_MON_009="Sep";
$MSG_MON_009E="September";
$MSG_MON_010="Oct";
$MSG_MON_010E="October";
$MSG_MON_011="Nov";
$MSG_MON_011E="November";
$MSG_MON_012="Dec";
$MSG_MON_012E="December";

#// Added for 2checkout customization
$MSG_2CK_0001 = "Payment Gateways Settings";
$MSG_2CK_0002 = "Enable 2checkout support?";
$MSG_2CK_0004 = "To charge your users fees to use your site's services, you can use one of the supported payment gateways below.<br />
All the gateways can be enabled, in that case your users will be able to choose which one they prefere to use.";
$MSG_2CK_0005 = "Enable Paypal support?";
$MSG_2CK_0007 = "Your Paypal e-mail address";
$MSG_2CK_0008 = "Your 2checkout seller ID";
$MSG_2CK_0009 = "Payment Gateways Settings Updated";
$MSG_2CK_0010 = "Pay by credit card at 2checkout.com";
$MSG_2CK_0011 = "To complete the sign up process, please proceed to pay the sign up fee of ";
$MSG_2CK_0012 = " through 2checkout by clicking on link below. ";
$MSG_2CK_0013 = "Click here to simulate Paypal Transaction";
$MSG_2CK_0014 = "To proceed to the payment use the link below.";
$MSG_2CK_0015 = "Thanks, Your payment has been properly processed.";
$MSG_2CK_0016 = "A problem occured during the payment process.";
$MSG_2CK_0017 = "2checkout routine";
$MSG_2CK_0018 = "This is the URL of the 2checkout payment routine to which users are redirected to proceed to the payment.
<br />There's shouldn't be any need to change it but check your 2checkout documentation to be sure it coincides with the one below";
$MSG_2CK_0019 = "Demo transaction, will not be processed";

$MSG_26_0001 = "Bids history";
$MSG_26_0002 = "Theme selection";
$MSG_26_0003 = "Themes available";
$MSG_26_0004 = "These are the themes actually installed in your site. Remember that theme change involves also logo and background!";
$MSG_26_0005 = "Theme Settings Updated";

#// GPL 3.0
$MSG_30_0001 = "Message posted";
$MSG_30_0002 = "Weight";
$MSG_30_0003 = "Style";
$MSG_30_0004 = "Edit Standard Font";
$MSG_30_0005 = "Edit Error Font";
$MSG_30_0006 = "Edit Title Font";
$MSG_30_0007 = "Edit Navigation Font";
$MSG_30_0008 = "Edit Footer Font";
$MSG_30_0009 = "The font properties of the fonts used on your site are defined in the CSS file of the active theme.
<BR />You can change them choosing the <B>Edit</B> option below for font type you want to customize.<BR />Alternatively you can edit the CSS file with your favourite text editor. We recommend this option only for user with CSS knowledge.";
$MSG_30_0010 = "Current CSS file: ";
$MSG_30_0011 = "Some of the colors used by the theme you have selected can be changed below.<BR />Choose the <B>Edit</B> option below for the color you want to change.
<BR />Alternatively you can edit the CSS file with your favourite text editor. We recommend this option only for user with CSS knowledge.";
$MSG_30_0012 =  "Edit Border Color";
$MSG_30_0013 =  "Table Header Color";
$MSG_30_0014 =  "This is the background color of the table headers.";
$MSG_30_0015 =  "Edit Table Header Color";
$MSG_30_0016 =  "Highlighted Items Background";
$MSG_30_0017 =  "This is the background color of the highlighted items.";
$MSG_30_0018 =  "Edit Highlighted Items Background";
$MSG_30_0019 =  "This is the color of the unvisited links.";
$MSG_30_0020 =  "Edit Links Color";
$MSG_30_0021 =  "This is the color of the visited links.";
$MSG_30_0022 =  "Edit Visited Links Color";
$MSG_30_0023 =  "Page Background Color";
$MSG_30_0024 =  "This is the background color of the pages.";
$MSG_30_0025 =  "Edit Page Background Color";
$MSG_30_0026 =  "Container Background Color";
$MSG_30_0027 =  "This is the background color of the most external box appearing in all pages.";
$MSG_30_0028 =  "Edit Container Background Color";
$MSG_30_0029 =  "You can set below the number of categories you want to be shown in the left column of the home page";
$MSG_30_0030 =  "Categories to show: ";
$MSG_30_0031 =  "Bids";
$MSG_30_0032 =  "Bids Retraction";
$MSG_30_0033 =  "As the administrator of the site, you have the possibility to retractdelete the last bid placed on an auction.
<BR />This is usefull when bidders enter a wrong amount for their bid and realize of the error soon after.
<BR /><B>Please note: only the last bid can be deleted</B>.
<BR /><BR />To retract a bid enter the auction id below or access the <A HREF=listauctions.php>Active Auctions List</A> to search for your auction and access the <B>Bids Retracting</B> option from there.";
$MSG_30_0034 =  "Proceed &gt;&gt;";
$MSG_30_0035 =  "Starts";
$MSG_30_0036 =  "Ends";
$MSG_30_0037 =  "Bid ID";
$MSG_30_0038 =  "Bid date";
$MSG_30_0039 =  "Bid amount";
$MSG_30_0040 =  "Bidder";
$MSG_30_0041 =  "Site Map";
$MSG_30_0042 =  "If the <B>Site Map</B> option is enabled, a link to the Site Map page will be displayed in the footer of your site.
<BR />The Site Map showns a resume of the main sections of your site. 
<BR /><BR />Enable Site Map option?";
$MSG_30_0043 =  "Site Map Settings Updated";
$MSG_30_0044 =  "Webstores";
$MSG_30_0045 =  "Unique Seller";
$MSG_30_0046 =  "You can choose to be the only seller on your auction site.
To enable this, register as a user, then select that user, from the list below.
Select 'No Unique Seller' if you don't want to activate the single seller option.";
$MSG_30_0047 = "No Unique Seller";
$MSG_30_0048 = "Unique Seller Settings Updated";
$MSG_30_0049 = "Newsletter Settings Updated";
$MSG_30_0050 = "Free E-mails Banning";
$MSG_30_0051 = "You can ban domain names of free e-mails services during your  users signup process. Please enter below the domain names (one per line) you want to ban.
<BR />Users trying to signup using an e-mail address belonging to one of the listed domains, will receive an error message asking to use a different e-mail address.<BR />Be sure to enter the complete domain name (i.e. hotmail.com, yahoo.com).";
$MSG_30_0052 = "Domains to ban";
$MSG_30_0053 = "Some free e-mail services have been banned from this website. Please do not enter e-mail addresses belonging to the following domains:";
$MSG_30_0054 = "Invalid e-mail address: free e-mails are not allowed on this website. Please use a different e-mail address.";

$MSG_30_0056 = "If you want invoices to be sent automatically, you'll need the ability to set up a cronjob on your server [<A HREF=batch.php>Read more</A>].";
$MSG_30_0057 = "Birthday Greetings";

$MSG_30_0059 = "Enable birthday greetings service?";
$MSG_30_0060 = "Birthday Greetings Settings Updated";
$MSG_30_0061 = "<B>Warning:</B> your installation is <A HREF=batch.php>configured to run <CODE>cron.php</CODE> in non-batch mode</A>. This means that <CODE>cron.php</CODE> will be executed every time someone accesses your home page.
<BR />It is not recommended to enable the Birthday Greetings service since your home page load could slow down dramatically when greetings e-mails are sent out. Anyway consider greetings e-mail are sent out only once a day.";
$MSG_30_0062 = "Please enter at least 4 characters";
$MSG_30_0063 = "Buy it now only?";
$MSG_30_0064 = "Activate <B>Buy it now only</B> auctions?";
$MSG_30_0065 = "Enabling the <B>Buy it now only</B> option you'll give your sellers the ability to set up auctions for which it will not be possible to place any bid, but only use the <B>Buy it now</B> feature (fixed price auctions).
<BR /><B>Note:</B> the <B>Buy it now only</B> option will only take effect if <B>Buy it now</B> is enabled.";
$MSG_30_0066 = "Buy it now only settings updates";
$MSG_30_0067 = "<B>Buy it now only</B> auction";
$MSG_30_0068 = "N/A";
$MSG_30_0069 = "Seller: edit this auction";
$MSG_30_0070 = "Search only in this category";
$MSG_30_0071 = "Adult Only Auctions";
$MSG_30_0072 = "Enabling this option you will give your sellers the possibility to post <B>Adult Only</B> auctions, which will only be visible to logged in users.";
$MSG_30_0073 = "Enable Adult Only Auctions?";
$MSG_30_0074 = "Adult Only Auctions Settings Updated";
$MSG_30_0075 = "Adult Only Auction?";
$MSG_30_0076 = "If the content of this auction is orientated towards an adult audience, please select <B>yes</B> below. Adult Only auctions will only be visible to logged in users";
$MSG_30_0077 = "Your payment details";
$MSG_30_0078 = "You can enter your payment details (i.e. paypal address, bank account information, etc).<BR />Buyers winning your auctions will receive them when they will be notified they won one of your auctions.";
$MSG_30_0079 = "Your payment details have been updated";
$MSG_30_0080 = "Payment Options";
$MSG_30_0081 = "Viewed ";
$MSG_30_0082 = " times";
$MSG_30_0083 = "Winners address in e-mails";
$MSG_30_0084 = "You can decide to have the winners address included in the notification e-mail sent to the seller when an auction closes. Just enable or disable this option below.";
$MSG_30_0085 = "Include winners' address in e-mails?";
$MSG_30_0086 = "Address: ";
$MSG_30_0087 = "Are you sure you want to process the selected auctions?";
$MSG_30_0088 = "Some of the fields in the sign up form, can be requested or not, and if requested they can be set as optional or required.<BR />Please make your selection below.";
$MSG_30_0089 = "Requested";
$MSG_30_0090 = "Optional";
$MSG_30_0091 = "Required";
$MSG_30_0092 = "Birth Date";
$MSG_30_0093 = "Address";
$MSG_30_0094 = "City";
$MSG_30_0095 = "Zip/Post Code";
$MSG_30_0096 = "Check All";
$MSG_30_0097 = "Uncheck";
$MSG_30_0098 = "&nbsp; = Outbidded";
$MSG_30_0099 = "Sell a similar item";
$MSG_30_0100 = "<B>Buy it now!</B> auctions";
$MSG_30_0101 = "<B>Buy it now only</B> auctions";
$MSG_30_0102 = "Check/Uncheck";
$MSG_30_0103 = "No winner";
$MSG_30_0104 = "Sending invoices is, by default, a semi-automatic process. You, as the administrator, will have to take care of periodically accessing the <A HREF=sendinvoices.php>Send Invoices</A> page and launching the procedure.
<BR />Alternatively, you can set up a cron job to have the invoices sending process run automatically (i.e. once a month).<BR />
The script you'll have to run is ";
$MSG_30_0105 = "E-mails banning settings updated";

$MSG_30_0107 = "Enable Authorize.net support?";
$MSG_30_0108 = "Login ID";
$MSG_30_0109 = "Transaction Key";
$MSG_30_0120 = "Authorize.net provided you with your <B>Login ID</B> and your <B>Transaction Key</B>. Please enter these values below.";
$MSG_30_0121 = "Pay through Authorize.net credit cards gateway";
$MSG_30_0122 = "Wanted Items";
$MSG_30_0123 = "Activating the <B>Wanted Items</B> option, you'll give your site's buyers the possibility to post ads about items they are looking for.<BR>
Seller will be able to browse the <B>Wanted Items</B> database and contact the buyers to redirect them to items (auctions) they are selling which respond to the buyer's request.
<BR /><BR />Enable <B>Wanted Items</B>?";
$MSG_30_0124 = "Wanted items settings updated";
$MSG_30_0125 = "Ad's Title";
$MSG_30_0126 = "Process selected ads";
$MSG_30_0127 = "Are you sure you want to process the selected ads?";
$MSG_30_0128 = "Post a new ad (wanted item)";
$MSG_30_0129 = "Wanted Item Ad";
$MSG_30_0130 = "Preview Ad";
$MSG_30_0131 = "You can still <a HREF='wanteditem.php?mode=recall'> make changes</a> to your ad";
$MSG_30_0132 = "Submit Ad";
$MSG_30_0133 = "Your ad has been properly received.<br />You can see the complete list of your <B>Wanted Items</B> <A HREF=wanted.php>here</B><br />";
$MSG_30_0134 = "Ad URL: ";
$MSG_30_0135 = "Post a similar ad";
$MSG_30_0136 = "Poster's Feedbacks ";
$MSG_30_0137 = "Poster: edit this ad";
$MSG_30_0138 = "Date posted";
$MSG_30_0139 = "Will close";
$MSG_30_0140 = "Ad ID";
$MSG_30_0141 = "Feedbacks received:&nbsp;";
$MSG_30_0142 = "Feedback score:&nbsp;";
$MSG_30_0143 = "Are you selling this item?";
$MSG_30_0144 = "Respond to this ad";
$MSG_30_0145 = "Back to the ad";
$MSG_30_0146 = "Wanted item: &nbsp;";
$MSG_30_0147 = "If you are selling this item just enter the <B>item number</B> below and click on the <B>Send</B> button.<BR>If you don't remember you item's number you can ";
$MSG_30_0148 = "see your current auctions here";
$MSG_30_0149 = "Item number";
$MSG_30_0150 = "Send &gt;";
$MSG_30_0151 = "Respond to <I>Wanted Item</I> request";
$MSG_30_0152 = "Please enter the Item Number";
$MSG_30_0153 = "The auction does not exist or it is closed or you are not the seller";
$MSG_30_0154 = "A problem occured while sendingcontacting the poster ofthis ad. Please contact the site's administrator.";
$MSG_30_0155 = "An e-mail has been sent to the poster of this ad.";
$MSG_30_0156 = "Answers";
$MSG_30_0157 = "View closed ads";
$MSG_30_0158 = "View open ads";
$MSG_30_0159 = "Wanted Items (closed)";
$MSG_30_0160 = "Edit Background Image Properties";
$MSG_30_0161 = "Ban";
$MSG_30_0162 = "Public Message Board for this auction";
$MSG_30_0163 = "Your Private Message Board for this auction";
$MSG_30_0164 = "Message Boards Settings";
$MSG_30_0165 = "Message Boards Settings Updated";
$MSG_30_0167 = "Public Message Board for: ";
$MSG_30_0168 = "login first";
$MSG_30_0169 = "Private Message Board for: ";
$MSG_30_0170 = "Private Message Boards for: ";
$MSG_30_0171 = "User";
$MSG_30_0172 = "Last Message Posted";
$MSG_30_0173 = "# Messages";
$MSG_30_0174 = "No private forums have been open for this auction";
$MSG_30_0175 = "Your private message boards";
$MSG_30_0176 = "View Winners";
$MSG_30_0177 = "Auction ended";
$MSG_30_0178 = "&nbsp;&nbsp;No winners found for this auction";
$MSG_30_0179 = "Winning bid";
$MSG_30_0180 = "Complete Bids History";
$MSG_30_0181 = "Message Board";
$MSG_30_0182 = "Reset your sell defaults";
$MSG_30_0183 = "Are you sure you want to reset your sell default values?";
$MSG_30_0185 = "Click here to continue";
$MSG_30_0187 =  "Navigation Bar Background Color";
$MSG_30_0188 =  "You can set below the color of the whole navigation bar where the links are shown in the header of your site.";
$MSG_30_0189 =  "Edit Navigation Bar Background Color";
$MSG_30_0191 =  "Auction Information Box Background Color";
$MSG_30_0192 =  "You can set below the color of the background of the box that shows the picture and auction information within the item's page.";
$MSG_30_0193 =  "Edit Auction Information Box Background Color";
$MSG_30_0207 = "Add Feedback";
$MSG_30_0208 = "Place bid >>";
$MSG_30_0209 = "Meet the seller";

################################################################################


// messages
$MSG_31_0001 = "View Bid Balance";
$MSG_31_0002 = "Bid Balance";
$MSG_31_0003 = "Your Offers";
$MSG_31_0004 = "Your Bid Balance";
$MSG_31_0005 = "Add Funds";
$MSG_31_0006 = '"Classic"';
$MSG_31_0007 = '"Extended"';
$MSG_31_0008 = '"Extended Reverse"';
$MSG_31_0009 = "Choose Auctions";
$MSG_31_0010 = "<h2 style='color:#cd0505;'>No live auctions at the moment</h2>";
$MSG_31_0011 = "Add new auction";
$MSG_31_0012 = "Set main auction";
$MSG_31_0013 = "Type auctions";
$MSG_31_0014 = "Reset main auction";
$MSG_31_0015 = "You must accept our terms and conditions to register!";
$MSG_31_0016 = "Emails do not match, please check!";
$MSG_31_0017 = "Welcome";
$MSG_31_0018 = "Your balance is";
$MSG_31_0019 = "Payments History";
$MSG_31_0020 = "View Payments History";
$MSG_31_0021 = "Sign up &raquo;&raquo;";
$MSG_31_0022 = "Select payment type";
$MSG_31_0023 = "This auction has now ended!";
$MSG_31_0024 = "The auction has started!";
$MSG_31_0025 = "Play";
$MSG_31_0026 = "You have already signed up for this auction!";
$MSG_31_0027 = "You need to be signed up with pre-payment to take part in this auction";
$MSG_31_0028 = "Your payments history";
$MSG_31_0029 = "You cannot play this action. It has already started!";
$MSG_31_0030 = "You can earn additional bids for this auction";
$MSG_31_0031 = "Add Bids";
$MSG_31_0032 = "View my auctions";
$MSG_31_0033 = "The auction ended!";
$MSG_31_0034 = "Single bid";
$MSG_31_0035 = "Place Bid";
$MSG_31_0036 = "Offer to range";
$MSG_31_0037 = "Num minimal users";
$MSG_31_0038 = "The auction has been successfully created.<br />";
$MSG_31_0039 = "You must first login to be able to contact Customer Service";
$MSG_31_0040 = "Pay your account";
$MSG_31_0041 = "You do not have enough bids in your account.<br /> <br /> <a href='user_menu.php'> Click here to get more! </a>.";
$MSG_31_0042 = "Thank you for your payment, now offers _OFFERS_ you have available, have fun!";
$MSG_31_0043 = "System error, please contact the Webmaster!";
$MSG_31_0044 = "Thank you for payment!";
$MSG_31_0045 = "Bad request!";
$MSG_31_0046 = "Browse more...";
$MSG_31_0047 = "Here you can see all bids that were placed on this auction. ";
$MSG_31_0048 = "How it works";
$MSG_31_0049 = "Activate this option if you want an <U>How it works</U> link to appear in the footer of your pages.";
$MSG_31_0050 = "Activate How it works page?";
$MSG_31_0051 = "How it works page content<br />(HTML allowed)";
$MSG_31_0052 = "How it works Settings Updated";
$MSG_31_0053 = "Wahoo! You now have the lowest unique bid!";
$MSG_31_0054 = "Your bid is unique but not the lowest, try another bid.";
$MSG_31_0055 = "Sorry, None of your bids are unique. Try another bid. ";
$MSG_31_0056 = "Your latest bid is not unique";
$MSG_31_0057 = "<br><br>You still have the lowest unique bid of: &pound;<winner_bid>";
$MSG_31_0058 = "Your bid of <winner_bid> is currently the lowest unique bid!";
$MSG_31_0059 = "Your bid is unique but not the lowest, try another bid.";
$MSG_31_0060 = "List of Offers";
$MSG_31_0061 = "Reset";
$MSG_31_0062 = "Auction was reset";
$MSG_31_0063 = "Are you sure you want to reset this auction?";
$MSG_31_0064 = "All auctions";

$MSG_33_0000="Display closed auctions?";
$MSG_33_0001="Select Yes if you want the closed auctions to be displayed in the Home page. Otherwise select No ";
$MSG_33_0002="Number of auctions which displayed on main page";


// errors
$ERR_32_0001 = "You don't have enough coins in your account to play.<div style='margin-top:12px;'><a href='user_menu.php' class='buttonbid'>Get More Coins!</a></div>";
$ERR_32_0002 = "You don't have enough offers to make this bid.";
$ERR_32_0003 = "You don't have enough offers to make this bid. Please, <a HREF='revolution_add_offers.php'>buy more offers</a>.";
$MSG_31_00651 = "There are only <b>".$bidsBeforeEnd." bids</b> left before this auction ends, but the range you just set would have placed <b>".$bidsWouldBePlaced." bids</b>. <br><br>Please adjust your range and bid again.<br><br><a href='item.php?id=$TPL_id_value&history=view#history' class='buttonbid'>
Back To Auction</a>";

// admin

$MSG_verified_1 = "<img src='//happybid.co.uk/images/verified.png'>";
$MSG_verified_0 = "<img src='//happybid.co.uk/images/verified-no.png'>";
$MSG_connected_1 = "<img src='//happybid.co.uk/images/fblogo.png' width='16'>";
$MSG_connected_0 = "none";
?>
