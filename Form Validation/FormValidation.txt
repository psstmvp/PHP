<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- 13-12-2021 03:24 PM
    Validation By Suraj -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Validation</title>
  </head>
  <body>
    <div align="center">
      <form method="post" action="#">
        <table border="1">
          <tr>
            <td>Name</td>
            <td><input required type="text" name="txt_name" title="Name Allows Only Alphabets,Spaces and First Letter Must Be Capital Letter" pattern="^[A-Z]+[a-zA-Z ]*$"/></td>
          </tr>
          <tr>
            <td>Gender</td>
            <td>
              <input type="radio" required name="rdo_gender" value="Male" />Male
              <input type="radio" name="rdo_gender" value="Female" />Female
              <input type="radio" name="rdo_gender" value="Others" />Others
            </td>
          </tr>
          <tr>
            <td>Contact</td>
            <td><input type="text" required name="txt_contact" pattern="[7-9]{1}[0-9]{9}" 
                title="Phone number with 7-9 and remaing 9 digit with 0-9"/></td>
          </tr>
          <tr>
            <td>Email</td>
            <td><input type="email" required name="txt_email" /></td>
          </tr>
          <tr>
            <td>Address</td>
            <td><textarea name="txt_address" required></textarea></td>
          </tr>
          <tr>
            <td>District</td>
            <td>
              <select name="sel_district" required>
                <option value="">----Select-----</option>
                <option value="1">Idukki</option>
                <option value="2">Ernakulam</option>
                <option value="3">Kottayam</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>Password</td>
            <td><input type="text" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required name="txt_pass" /></td>
          </tr>
          <tr>
            <td>Re-Password</td>
            <td><input type="password" required name="txt_repass" /></td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <input type="submit" name="btn_submit" value="Submit" />
            </td>
          </tr>
        </table>
      </form>
    </div>
  </body>
</html>