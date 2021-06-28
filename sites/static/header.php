<style>

/*#########################
  H E A D E R
*/
@media only screen and (max-device-width: 600px) {
  #header {
    margin-top: 5px;
    background-color: #e9e9e9;
    display: flex;
    width: 100%;
    height: 50px;
    box-shadow: 0 5px #E0E0E0;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 15px;
    padding: 0 10%;
    color: black;
  }
}
#header {
  margin-top: 5px;
  background-color: #e9e9e9;
  display: flex;
  /* width: 0%; */
  height: 50px;
  box-shadow: 0 5px #E0E0E0;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 15px;
  padding: 0 10%;
  color: black;
}
#header a #title {
  font-weight: bolder;
  font-size: 22px;
  background-color: #e9e9e9;
}
#header .searchbar {
  width: 100px;
  height: 20px;
  border: 1px solid lightgray;
  border-radius: 5px;
  padding-left: 200px;
  box-sizing: border-box;
  /* background-color: #e9e9e9; */
  color: black;
  background: url(https://cdn3.iconfinder.com/data/icons/google-material-design-icons/48/ic_search_48px-128.png);
  background-size: 16px;
  background-repeat: no-repeat;
  background-position: 50% 0;
}
#header .searchbar:focus {
  padding-left: 200px;
  background-position: 5px 0;
  color: black;
}
#header .dropdown .profile-btn {
  border: none;
  background-color: #e9e9e9;
}
#header .dropdown {
  background-color: #e9e9e9;
  position: relative;
  display: inline-block;
  padding: 10px;
}
#header .dropdown .dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  top: 50px;
  left: -78px;
  min-width: 160px;
  height: 150px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  padding: 16px 16px;
  z-index: 1;
}
#header .dropdown .dropdown-content::after {
  content: "";
  position: absolute;
  bottom: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent transparent #f9f9f9 transparent;
}
#header .dropdown:hover .dropdown-content {
  display: block;
}
#header .dropdown .dropdown-content .btn {
  padding: 8px 40px;
  background-color: lightblue;
}
#header .dropdown .dropdown-content ul {
  list-style-type: none;
}
#header .dropdown .dropdown-content ul li {
  margin: 0 0 20px 0;
  min-width: 0px;
}
#header a {
  color: inherit;
  text-decoration: none;
  background-color: #e9e9e9;
}
</style>

<div id="header">
  <div id="title">
    <a href="?p=index">ProjektA</a>
  </div>
  <form action="?p=user" method="post">
    <input class="searchbar" type="text" name="search" placeholder="Suchen..." autocomplete="off">
  </form>
  <div class="dropdown">
    <a href="?p=profile" class="profile-btn">
        <i class="fa fa-user-circle-o fa-2x" aria-hidden="true"></i>
    </a>
    <?php if(isset($_SESSION['UID'])) {  ?>
      <div class="dropdown-content">
        <ul>
          <li><a href="?p=account" class="btn">Kontosettings</a></li>
          <li><a href="?p=logout" class="btn">Ausloggen</a></li>
        </ul>
      </div>
    <?php } ?>
  </div>
</div>
