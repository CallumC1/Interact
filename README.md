Useful commands:
```
Run Tailwind.
npx tailwindcss -i ./src/input.css -o ./dist/output.css --watch
```

Database commands:
```
CREATE TABLE `users` (
  `user_id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `user_first_name` varchar(50) NOT NULL,
  `user_last_name` varchar(50) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `user_password_hash` varchar(255) NOT NULL,
  `user_role` varchar(50) NOT NULL DEFAULT 'user',
  `user_about` varchar(255)
);

CREATE TABLE `messages` (
  `message_id` INT PRIMARY KEY AUTO_INCREMENT,
  `sender_id` INT NOT NULL,
  `message` TEXT NOT NULL,
  FOREIGN KEY (`sender_id`) REFERENCES `users`(`user_id`)
);

CREATE TABLE likes (
  like_id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT,
  message_id INT,
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (message_id) REFERENCES messages(message_id)
);
```