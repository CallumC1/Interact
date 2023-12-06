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
  `user_role` varchar(50) NOT NULL DEFAULT 'user'
)
```