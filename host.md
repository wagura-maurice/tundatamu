sudo nano /etc/nginx/sites-available/e4Impact.waguramaurice.com

server {
listen 80;
listen [::]:80;

        root /var/www/html/jenga/current/public;
        index index.php index.html index.htm index.nginx-debian.html;

        server_name e4Impact.waguramaurice.com;

        location / {
                try_files $uri $uri/ /index.php?$query_string;
        }


        location ~ \.php$ {
                include snippets/fastcgi-php.conf;

                fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
                fastcgi_param DOCUMENT_ROOT $realpath_root;
                include fastcgi_params;

                fastcgi_pass unix:/run/php/php7.4-fpm.sock;

        }

        location ~ /\.ht {
                deny all;
        }

}

sudo ln -s /etc/nginx/sites-available/e4Impact.waguramaurice.com /etc/nginx/sites-enabled/
