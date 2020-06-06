<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
?>
<div class="content">
  <title><?php echo $title ?></title>
                <section class="content__side">
                    <h2 class="content__side-heading">Проекты</h2>

                    <nav class="main-navigation">
                        <?php
                        $projectname = ['Входящие', 'Учёба', 'Работа', 'Домашние дела', 'Авто'];
                        $tasksall = array(
                            $task = ['Задача', 'Дата выполнения', 'Категория', 'Выполнена'],
                            $task = ['Собеседование в IT компании', '05.06.2020', 'Работа', false],
                            $task = ['Выполнить тестовое задание', '06.06.2020', 'Работа', false],
                            $task = ['Сделать задание первого раздела', '03.06.2020', 'Учёба', true],
                            $task = ['Встреча с другом', '06.06.2020', 'Входящие', false],
                            $task = ['Купить корм для кота', 'без времени', 'Домашние дела', false],
                            $task = ['Заказать пиццу', 'без времени', 'Домашние дела', false]
                        );
                        ?>
                        <form method="POST">
                        <ul class="main-navigation__list">
                            <?php
                            function getCountTasksInProject ($projects, $arrayTasks) {
                                $count = 0;
                                foreach($arrayTasks as $task) {
                                    if($projects == $task[2]) {
                                        $count++;
                                    }
                                }
                                return $count;
                            }
                            foreach ($projectname as $tab) {
                            echo '
                                <li class="main-navigation__list-item">
                                <input name="clicktab" type="submit" class="main-navigation__list-item-link" value="'. $tab .'">
                                <span class="main-navigation__list-item-count">'.getCountTasksInProject($tab, $tasksall).'</span>
                                </li>';
                            };
                            ?>
                        </ul>
                        </form>
                    </nav>

                    <a class="button button--transparent button--plus content__side-button" href="pages/form-project.html" target="project_add">Добавить проект</a>
                </section>

                <main class="content__main">
                    <h2 class="content__main-heading">Список задач</h2>

                    <form class="search-form" action="index.php" method="post" autocomplete="off">
                        <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

                        <input class="search-form__submit" type="submit" name="" value="Искать">
                    </form>
                            
                    <div class="tasks-controls">
                        <nav class="tasks-switch">
                            <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
                            <a href="/" class="tasks-switch__item">Повестка дня</a>
                            <a href="/" class="tasks-switch__item">Завтра</a>
                            <a href="/" class="tasks-switch__item">Просроченные</a>
                        </nav>

                        <label class="checkbox">
                            <!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
                            <input class="checkbox__input visually-hidden show_completed" type="checkbox"
                            <?php
                                if ($show_complete_tasks == 1) {
                                    echo 'checked';
                                }
                            ?>>
                            <span class="checkbox__text">Показывать выполненные</span>
                        </label>
                    </div>

                    <table class="tasks">
                        <tr class="tasks__item task">
                            <td class="task__select">
                                <label class="checkbox task__checkbox">
                                    <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
                                    <span class="checkbox__text">Сделать главную страницу Дела в порядке</span>
                                </label>
                            </td>

                            <td class="task__file">
                                <a class="download-link" href="#">Home.psd</a>
                            </td>

                            <td class="task__date"></td>
                        </tr>
                        <!--показывать следующий тег <tr/>, если переменная $show_complete_tasks равна единице-->
                        <?php
                        $showtask = '<tr class="tasks__item task task--completed">
                        <td class="task__select">
                            <label class="checkbox task__checkbox">
                                <input class="checkbox__input visually-hidden" type="checkbox" checked>
                                <span class="checkbox__text">Записаться на интенсив "Базовый PHP"</span>
                            </label>
                        </td>
                        <td class="task__date">10.10.2019</td>
                        <td class="task__controls"></td>
                    </tr>';
                        if ($show_complete_tasks == 1) {
                            echo "$showtask";
                        }
                        //нажатие табов
                    if (isset($_POST['clicktab'])) {
                        $arrshow = [];
                        foreach($tasksall as $valuetask) {
                            if ($_POST['clicktab'] == $valuetask[2]) {
                                $arrshow[] = $valuetask;
                            } 
                        } 
                        if (count($arrshow)){
                            foreach($arrshow as $task) {
                                $date = $task[1];
                                $taskImportant = '';
                                if(strpos($date, '.')){
                                    $nowDate = getdate();
                                    $timeOff = strtotime($date) - strtotime($nowDate["mday"].'.'.$nowDate["mon"].'.'.$nowDate["year"]);
                                    $taskImportant = $timeOff <= 86400 && $timeOff > -86400 ? 'task--important' : '';
                                    
                                }
                                if (true){
                                    $checkedclassname = $task[3] ? 'task--completed' : '';
                                    $checkcheked = $task[3] ? 'checked' : '';
                                    echo '<tr class="tasks__item task '.$checkedclassname.' '.$taskImportant.'">
                                    <td class="task__select">
                                        <label class="checkbox task__checkbox">
                                            <input class="checkbox__input visually-hidden" type="checkbox" '.$checkcheked.'>
                                            <span class="checkbox__text">'.$task[0].'</span>
                                        </label>
                                    </td>
                                    <td class="task__date ">'.$date.'</td>
                                    <td class="task__controls"> </td>
                                </tr>';
                                }
                            }
                        } else {
                            echo 'Нет задач';
                        }
                        
                    }  

                        ?>
                    </table>
                </main>
            </div>