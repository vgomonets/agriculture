<div class="mobile-menu-left-overlay"></div>
<nav class="side-menu">
    <ul class="side-menu-list">

        <li class="purple  {{ (Request::path() ==  'activity') ? 'opened' : ''  }}">
            <a href="/activity">
                <i class="glyphicon font-icon-zigzag"></i>
                <span class="lbl">Активность</span>
            </a>
        </li>

        <li class="blue {{ (Request::path() ==  'holding') ? 'opened' : ''  }}">
            <a href="/holding">
                <i class="glyphicon glyphicon-list-alt"></i>
                <span class="lbl">Холдинги</span>
            </a>
        </li>

        <li class="red with-sub">
            <span>
                <span class="font-icon font-icon-contacts"></span>
                <span class="lbl">Клиенты</span>
            </span>
            <ul>
                <li class="{{ (Request::path() ==  'contractor/activity') ? 'opened' : ''  }}">
                    <a href="/contractor/activity">
                        <span class="lbl">Виды деятельности</span>
                    </a>
                </li>
                <li class="{{ (Request::path() ==  'contractor/group') ? 'opened' : ''  }}">
                    <a href="/contractor/group">
                        <span class="lbl">Группы</span>
                    </a>
                </li>
                <li class="{{ (Request::path() ==  'contractor') ? 'opened' : ''  }}">
                    <a href="/client">
                        <span class="lbl">Клиенты</span>
                    </a>
                </li>

                <!-- <li class="{{ (Request::path() ==  'company') ? 'opened' : ''  }}">
                    <a href="/company">
                        <span class="lbl">Компании</span>
                    </a>
                </li> -->
            </ul>
        </li>

        <!-- <li class="gold  {{ (Request::path() ==  '1') ? 'opened' : ''  }}">
            <a href="/">
                <i class="glyphicon glyphicon-signal"></i>
                <span class="lbl">Продажи</span>
            </a>
        </li> -->

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

        <li class="red with-sub">
            <span>
                <span class="glyphicon glyphicon-tasks"></span>
                <span class="lbl">Задачи</span>
            </span>
            <ul>
                <li class="red  {{ (Request::path() ==  'task') ? 'opened' : ''  }}">
                    <a href="/task">
                        <span class="lbl">Задачи</span>
                    </a>
                </li>
                <li class="red  {{ (Request::path() ==  'task/group') ? 'opened' : ''  }}">
                    <a href="/task/group">
                        <span class="lbl">Шаблоны задач</span>
                    </a>
                </li>
                <li class="red  {{ (Request::path() ==  'business/actions') ? 'opened' : ''  }}">
                    <a href="/business/actions">
                        <span class="lbl">Действия</span>
                    </a>
                </li>
                <li class="red  {{ (Request::path() ==  'agrorotation/date') ? 'opened' : ''  }}">
                    <a href="/agrorotation/date">
                        <span class="lbl">Даты севооборота</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="blue  {{ (Request::path() ==  'calendar') ? 'opened' : ''  }}">
            <a href="/calendar">
                <i class="glyphicon font-icon-calend"></i>
                <span class="lbl">Календарь</span>
            </a>
        </li>

        <!-- <li class="red  {{ (Request::path() ==  '1') ? 'opened' : ''  }}">
            <a href="/">
                <i class="glyphicon font-icon-alarm"></i>
                <span class="lbl">Напоминания</span>
            </a>
        </li> -->

        <!-- <li class="yellow  {{ (Request::path() ==  '1') ? 'opened' : ''  }}">
            <a href="/">
                <i class="glyphicon font-icon-chart"></i>
                <span class="lbl">Статистика</span>
            </a>
        </li> -->

        <li class="gold {{ (Request::path() ==  'staff/users' || Request::path() ==  '/') ? 'opened' : ''  }}">
            <a href="/staff/users">
                <i class="font-icon font-icon-users"></i>
                <span class="lbl">Пользователи</span>
            </a>
        </li>

        <!-- <li class="magenta with-sub">
            <span>
                <span class="font-icon font-icon-map"></span>
                <span class="lbl">Локации</span>
            </span>
            <ul>
                <li class="blue  {{ (Request::path() ==  'region') ? 'opened' : ''  }}">
                    <a href="/region">
                        <span class="lbl">Регионы</span>
                    </a>
                </li>
                <li class="blue  {{ (Request::path() ==  'city') ? 'opened' : ''  }}">
                    <a href="/city">
                        <span class="lbl">Города</span>
                    </a>
                </li>
            </ul>
        </li> -->
        <li class="blue  {{ (Request::path() ==  'city') ? 'opened' : ''  }}">
            <a href="/city">
                <span class="font-icon font-icon-map"></span>
                <span class="lbl">Города</span>
            </a>
        </li>

        <li class="brown with-sub">
            <span>
                <span class="font-icon font-icon-chart"></span>
                <span class="lbl">Аналитика</span>
            </span>
            <ul>
                <li class="red  {{ (Request::path() ==  'task') ? 'opened' : ''  }}">
                    <a href="/statistic/manager">
                        <span class="lbl">Эффективность менеджеров</span>
                    </a>
                </li>
                <li class="red  {{ (Request::path() ==  'task/group') ? 'opened' : ''  }}">
                    <a href="/statistic/call">
                        <span class="lbl">Встречи-звонки</span>
                    </a>
                </li>
                <li class="red  {{ (Request::path() ==  'task/group') ? 'opened' : ''  }}">
                    <a href="/statistic/client">
                        <span class="lbl">Клиенты</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav><!--.side-menu-->
