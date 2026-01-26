<div style="background: #f0f0f0; padding: 20px; border: 2px solid #000; margin: 10px 0;">
    <h4>Admin Navigation</h4>
    <div style="display: flex; gap: 19px; flex-wrap: wrap;">
        <?php
        $admin_services = Session::get('services');
        $ser = json_decode($admin_services);
        if ($ser[0] == "999") {
            $admin_sidebar = App\adminmodel\AdminSidebar::OrderBy('seq', 'asc')->get();
            if (!empty($admin_sidebar)) {
                foreach ($admin_sidebar as $sidebar) {
                    if ($sidebar->url == "#") {
                        // Dropdown menu
                        $admin_sidebar2 = App\adminmodel\AdminSidebar2::where('main_id', $sidebar->id)->get();
                        if (!empty($admin_sidebar2)) {
        ?>
        <div style="position: relative; display: inline-block;" onmouseover="showDropdown(this)" onmouseout="hideDropdown(this)">
            <button style="border: none; border-radius: 5px; cursor: pointer;">
                <i class="<?= $sidebar->icon ?>" style="margin-right: 5px;"></i>
                {{$sidebar->name}} 
            </button>
            <div class="dropdown-menu" style="display: none; position: absolute; background: white; min-width: 200px; box-shadow: 0px 8px 16px rgba(0,0,0,0.2); z-index: 1; border-radius: 5px; top: 100%;">
                <?php foreach ($admin_sidebar2 as $sidebar2) { ?>
                <a href="{{route($sidebar2->url)}}" style="color: black; padding: 12px 16px; text-decoration: none; display: block; border-bottom: 1px solid #eee;">
                    {{$sidebar2->name}}
                </a>
                <?php } ?>
            </div>
        </div>
        <?php
                        }
                    } else {
                        // Direct link
        ?>
        <a href="{{route($sidebar->url)}}" style="background:  text-decoration: none; border-radius: 5px; display: inline-flex; align-items: center;">
            <i class="<?= $sidebar->icon ?>" style="margin-right: 5px;"></i>
            {{$sidebar->name}}
        </a>
        <?php
                    }
                }
            }
        } else {
            foreach ($ser as $s) {
                $sidebar = App\adminmodel\AdminSidebar::where('id', $s)->first();
                if (!empty($sidebar)) {
                    if ($sidebar->url == "#") {
                        // Dropdown menu
                        $admin_sidebar2 = App\adminmodel\AdminSidebar2::where('main_id', $sidebar->id)->get();
                        if (!empty($admin_sidebar2)) {
        ?>
        <div style="position: relative; display: inline-block;" onmouseover="showDropdown(this)" onmouseout="hideDropdown(this)">
            <button style="background: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">
                <i class="<?= $sidebar->icon ?>" style="margin-right: 5px;"></i>
                {{$sidebar->name}} 
            </button>
            <div class="dropdown-menu" style="display: none; position: absolute; background: white; min-width: 200px; box-shadow: 0px 8px 16px rgba(0,0,0,0.2); z-index: 1; border-radius: 5px; top: 100%;">
                <?php foreach ($admin_sidebar2 as $sidebar2) { ?>
                <a href="{{route($sidebar2->url)}}" style="color: black; padding: 12px 16px; text-decoration: none; display: block; border-bottom: 1px solid #eee;">
                    {{$sidebar2->name}}
                </a>
                <?php } ?>
            </div>
        </div>
        <?php
                        }
                    } else {
                        // Direct link
        ?>
        <a href="{{route($sidebar->url)}}" style="background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-flex; align-items: center;">
            <i class="<?= $sidebar->icon ?>" style="margin-right: 5px;"></i>
            {{$sidebar->name}}
        </a>
        <?php
                    }
                }
            }
        }
        ?>
    </div>
</div>

    <style>
.admin-btn{
    background: #007bff;
    color: #fff;
    padding: 10px 16px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    cursor: pointer;
    border: none;
}

.admin-btn:hover{
    background: #0056b3;
}

.dropdown-menu a{
    color:#333;
}

.dropdown-menu a:hover{
    background:#f2f2f2;
}
</style>



<script>
function showDropdown(element) {
    var dropdown = element.querySelector('.dropdown-menu');
    if (dropdown) {
        dropdown.style.display = 'block';
    }
}

function hideDropdown(element) {
    var dropdown = element.querySelector('.dropdown-menu');
    if (dropdown) {
        setTimeout(function() {
            if (!element.matches(':hover')) {
                dropdown.style.display = 'none';
            }
        }, 500);
    }
}
</script>
