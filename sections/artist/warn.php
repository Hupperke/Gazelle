<?php
if (!check_perms('users_warn')) { error(404);}
Misc::assert_isset_request($_POST, array('artistid', 'postid', 'userid', 'key'));

$ArtistID = (int) $_POST['artistid'];
$PostID = (int) $_POST['postid'];
$UserID = (int) $_POST['userid'];
$Key = (int) $_POST['key'];
$UserInfo = Users::user_info($UserID);
$DB -> query("SELECT
    ac.Body,
    ac.AddedTime
    FROM artist_comments AS ac
    WHERE ac.ID='" . db_string($PostID) . "'");
list($PostBody) = $DB -> next_record();

View::show_header('Warn User');
?>

<div class="thin">
	<div class="header">
		<h2>Warning <a href="user.php?id=<?=$UserID?>"><?=$UserInfo['Username']?></a></h2>
	</div>
	<div class="thin box pad">
		<form class="create_form" name="warning" action="" onsubmit="quickpostform.submit_button.disabled=true;" method="post">
			<input type="hidden" name="artistid" value="<?=$ArtistID?>"/>
			<input type="hidden" name="postid" value="<?=$PostID?>"/>
			<input type="hidden" name="userid" value="<?=$UserID?>"/>
			<input type="hidden" name="key" value="<?=$Key?>"/>
			<input type="hidden" name="action" value="take_warn"/>
			<table class="layout" align="center">
				<tr>
					<td class="label">Reason:</td>
					<td>
					<input type="text" name="reason" size="30" />
					</td>
				</tr>
				<tr>
					<td class="label">Length:</td>
					<td>
					<select name="length">
						<option value="verbal">Verbal</option>
						<option value="1">1 week</option>
						<option value="2">2 week</option>
						<option value="4">4 week</option>
						<? if(check_perms("users_mod")) { ?>
						<option value="8">8 week</option>
						<? } ?>
					</select></td>
				</tr>
				<tr>
					<td class="label">Private Message:</td>
					<td>
					<textarea id="message" style="width: 95%;" tabindex="1" onkeyup="resize('message');" name="privatemessage" cols="90" rows="4"></textarea>
					</td>
				</tr>
				<tr>
					<td class="label">Edit Post:</td>
					<td>
						<textarea id="body" style="width: 95%;" tabindex="1" onkeyup="resize('body');" name="body" cols="90" rows="8"><?=$PostBody?></textarea>
						<br />
						<input type="submit" id="submit_button" value="Warn User" tabindex="1" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<? View::show_footer(); ?>
