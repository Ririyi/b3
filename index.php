<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма регистрации</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f7f7f7;
            overflow: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            overflow: auto;
            max-height: 90vh;
        }

        .form-container h2 {
            margin: 0 0 15px;
        }

        .form-row {
            margin-bottom: 20px;
        }

        .form-container input,
        .form-container textarea,
        .form-container select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }

        .form-container button:hover {
            background: #0056b3;
        }

        .gender-container {
            display: flex;
            margin-top: 5px;
        }

        .form-check {
            margin-right: 20px;
            display: flex;
            align-items: center;
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .form-group label {
            margin-left: 5px;
            margin-bottom: 0;
        }

        .form-check-input {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Регистрация</h2>
        <form id="registrationForm" action="bd.php" method="POST">
            <div class="form-row">
                <label for="field-name-1">ФИО:</label>
                <input type="text" name="fio" class="form-control" id="fio" placeholder="Иванов Иван Иванович" required>
            </div>
            <div class="form-row">
                <label for="tel">Номер телефона:</label>
                <input type="tel" name="tel" class="form-control" id="tel" placeholder="Введите ваш номер" required>
            </div>
            <div class="form-row">
                <label for="field-email">Email:</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Введите вашу почту" required>
            </div>
            <div class="form-row">
                <label for="field-date">Дата рождения:</label>
                <input type="date" name="date" class="form-control" id="date" required>
            </div>
            <div class="form-row">
                <label>Пол:</label>
                <div class="gender-container">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="radio-male" value="male" required>
                        <label class="form-check-label" for="radio-male">Мужской</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="radio-female" value="female" required>
                        <label class="form-check-label" for="radio-female">Женский</label>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <label for="field-name-4">Любимый язык программирования:</label>
                <select class="form-control" name="plang[]" id="field-name-4" multiple required>
                    <option value="Pascal">Pascal</option>
                    <option value="C">C</option>
                    <option value="C++">C++</option>
                    <option value="JavaScript">JavaScript</option>
                    <option value="PHP">PHP</option>
                    <option value="Haskell">Haskell</option>
                    <option value="Clojure">Clojure</option>
                    <option value="Prolog">Prolog</option>
                    <option value="Scala">Scala</option>
                </select>
            </div>
            <div class="form-row">
                <label for="field-name-2">Биография:</label>
                <textarea class="form-control" name="bio" id="field-name-2" rows="3" placeholder="Расскажите о себе" required></textarea>
            </div>
            <div class="form-row form-group">
                <input type="checkbox" class="form-check-input" name="check" id="check" required>
                <label class="form-check-label" for="check-1">С контрактом ознакомлен(а)</label>
            </div>
            <button type="submit">Сохранить</button>
        </form>
        <div class="message" id="message"></div>
    </div>
</body>
</html>
