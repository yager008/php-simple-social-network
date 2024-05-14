<form method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>NameText:</td>
            <td><input type="text" name="nameText" id="nameText" placeholder="<?php echo $_SESSION['nameBuffer']?>"></td>
        </tr>
        <tr>
            <td>SurnameText: </td>
            <td><input type="text" name="surnameText" id="surnameText" placeholder="<?php echo $_SESSION['surnameBuffer']?>" ></td>
        </tr>
        <tr>
            <td>About me text: </td>
            <td><textarea  style="resize: none" name="aboutMeText" id="aboutMeText" placeholder="<?php echo $_SESSION['aboutMeBuffer']?>"></textarea></td>
        </tr>
        <tr>
            <td>File input: </td>
            <td><input type="file" name="fileInput" id="fileInput"></td>
        </tr>
        <tr>
            <td><input type="submit" name="submitEditProfileButton"></td>
        </tr>
    </table>
</form>


