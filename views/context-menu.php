<style>
  #context-menu {
    position: fixed;
    z-index: 10000;
    width: 150px;
    background: #1b1a1a;
    border-radius: 5px;
    transform: scale(0);
    transform-origin: top left;
  }

  #context-menu.active {
    transform: scale(1);
    transition: transform 300ms ease-in-out;
  }

  #context-menu .item {
    padding: 8px 10px;
    font-size: 15px;
    color: #eee;
    cursor: pointer;
  }

  #context-menu .item:hover {
    background: #555;
  }

  #context-menu .item i {
    display: inline-block;
    margin-right: 5px;
  }

  #context-menu hr {
    margin: 2px 0px;
    border-color: #555;
  }
</style>
<div id="context-menu">
  <div class="item" id="historial">
    <i class="fas fa-history"></i><span> Ver Historial</span>
  </div>
  <hr>
  <div class="item" id="Cerificados">
    <i class="fas fa-certificate"></i><span> Ver Certificados </span>
  </div>

</div>