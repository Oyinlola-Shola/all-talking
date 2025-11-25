./vendor/bin/openapi \
  --bootstrap vendor/autoload.php \
  --output src/docs/newdichsrc.json \
  --exclude vendor \
  --exclude apis \
  --exclude phpmyadmin \
  --exclude public \
  --exclude route \
  --exclude Schema \
  --exclude composer.json \
  --exclude composer.lock \
  --exclude index.php \
  src/


./vendor/bin/openapi \
  --bootstrap vendor/autoload.php \
  --output app/docs/newdichapp.json \
  --exclude vendor \
  --exclude phpmyadmin \
  --exclude apis \
   --exclude public \
  --exclude route \
  --exclude Schema \
  --exclude composer.json \
  --exclude composer.lock \
  --exclude index.php \
  app/