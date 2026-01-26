<div style="background:#f0f0f0; padding:20px; border:2px solid #4a4f96; margin:10px 0;">
    <h4>Admin Navigation</h4>

    <div style="display:flex; gap:5px; flex-wrap:wrap;">
    <?php
    $admin_services = Session::get('services');
    $ser = json_decode($admin_services);

    if ($ser[0] == "999") {
        $admin_sidebar = App\adminmodel\AdminSidebar::orderBy('seq','asc')->get();
    } else {
        $admin_sidebar = [];
        foreach ($ser as $s) {
            $admin_sidebar[] = App\adminmodel\AdminSidebar::where('id',$s)->first();
        }
    }

    foreach ($admin_sidebar as $sidebar) {
        if (!$sidebar) continue;

        /* ========== DROPDOWN ========== */
        if ($sidebar->url == "#") {

            $admin_sidebar2 = App\adminmodel\AdminSidebar2::where('main_id',$sidebar->id)->get();
            if ($admin_sidebar2->count() == 0) continue;
    ?>
        <div class="menu-item"
             onmouseover="showDropdown(this)"
             onmouseout="hideDropdown(this)">

            <button class="admin-btn admin-btn-green">
                <i class="<?= $sidebar->icon ?>"></i>
                {{ $sidebar->name }}
            </button>

            <div class="dropdown-menu">
                <?php foreach ($admin_sidebar2 as $sidebar2) { ?>
                    <a href="{{ route($sidebar2->url) }}" class="dropdown-btn">
                        {{ $sidebar2->name }}
                    </a>
                <?php } ?>
            </div>
        </div>

    <?php
        }
        /* ========== DIRECT LINK ========== */
        else {
    ?>
        <a href="{{ route($sidebar->url) }}" class="admin-btn admin-btn-blue">
            <i class="<?= $sidebar->icon ?>"></i>
            {{ $sidebar->name }}
        </a>
    <?php
        }
    }
    ?>
    </div>
</div>
<style>
    /* ===============================
   COMMON ADMIN BUTTON
================================ */
.admin-btn{
    background:#007bff;
    color:#fff;
    padding:7px 6.5px;
    border-radius:6px;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:6px;
    font-size:14px;
    font-weight:500;
    cursor:pointer;
    border:none;
    transition:all .25s ease;
}

.admin-btn-green{ background:#28a745; }
.admin-btn-blue{ background:#007bff; }

.admin-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 14px rgba(0,0,0,.25);
    opacity:.95;
}

/* ===============================
   DROPDOWN
================================ */
.menu-item{
    position:relative;
    display:inline-block;
}

.dropdown-menu{
    display:none;
    position:absolute;
    top:100%;
    left:0;
    min-width:200px;
    background:#fff;
  
    border-radius:6px;
    box-shadow:0 8px 16px rgba(0,0,0,.2);
    z-index:999;
}

.dropdown-btn{
    display:block;
    width:100%;
    background:#f8f9fa;
    color:#333;
    padding:10px 14px;
    margin-bottom:6px;
    border-radius:6px;
    text-decoration:none;
    font-size:14px;
    font-weight:500;
    border:1px solid #ddd;
    transition:all .25s ease;
}

.dropdown-btn:last-child{ margin-bottom:0; }

.dropdown-btn:hover{
    background:#007bff;
    color:#fff;
    border-color:#007bff;
    transform:translateX(4px);
    box-shadow:0 4px 10px rgba(0,0,0,.15);
}

</style>
<script>
function showDropdown(el){
    const menu = el.querySelector('.dropdown-menu');
    if(menu) menu.style.display = 'block';
}

function hideDropdown(el){
    const menu = el.querySelector('.dropdown-menu');
    if(menu){
        setTimeout(() => {
            if(!el.matches(':hover')){
                menu.style.display = 'none';
            }
        }, 300);
    }
}
</script>
