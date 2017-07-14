<div class="mobile-menu-left-overlay"></div>
<nav class="side-menu">
    <ul class="side-menu-list">

        <li class="purple  {{ (Request::path() ==  'activity') ? 'opened' : ''  }}">
            <a href="/activity">
                <i class="glyphicon font-icon-zigzag"></i>
                <span class="lbl">Активность</span>
            </a>
        </li>

        <li class="red with  {{ (Request::path() ==  'contractor') ? 'opened' : ''  }}">
            <a href="/client">
                <i class="glyphicon glyphicon-user"></i>
                <span class="lbl">Клиенты</span>
            </a>
        </li>

        <li class="blue  {{ (Request::path() ==  'nomenclatura') ? 'opened' : ''  }}">
            <a href="/nomenclatura">
                <i class="glyphicon glyphicon-shopping-cart"></i>
                <span class="lbl">Товары</span>
            </a>
        </li>

        <li class="purple  {{ (Request::path() ==  'order') ? 'opened' : ''  }}">
            <a href="/order">
                <i class="glyphicon font-icon-notebook"></i>
                <span class="lbl">Заказы</span>
            </a>
        </li>

        <li class="red with {{ (Request::path() ==  'task') ? 'opened' : ''  }}">
            <a href="/task">
                <i class="glyphicon glyphicon-tasks"></i>
                <span class="lbl">Задачи</span>
            </a>
        </li>

        <li class="blue  {{ (Request::path() ==  'calendar') ? 'opened' : ''  }}">
            <a href="/calendar">
                <i class="glyphicon font-icon-calend"></i>
                <span class="lbl">Календарь</span>
            </a>
        </li>
    </ul>
</nav><!--.side-menu-->
