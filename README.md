# Yapılacaklar Uygulaması (ToDo App)

Bu açık kaynaklı yapılacaklar uygulaması (ToDo App), Toruk MAGIC Deep Tech şirketi tarafından geliştirilmiş olup, şirketin temel değerlerinden biri olan bilgi paylaşımını teşvik etme ve yeni başlayan arkadaşlara yol gösterme vizyonunu yansıtmaktadır.

## Vizyonumuz 

Toruk MAGIC Deep Tech olarak, bilginin paylaştıkça çoğalacağına olan inancımızı temel alarak, bu açık kaynaklı uygulama aracılığıyla bilgi ve deneyimimizi geniş bir topluluğa açmayı hedefliyoruz. Yeni başlayan geliştiricilere rehberlik etmek ve katılımcılarımızın uygulama geliştirme konusundaki becerilerini artırmak için bu proje üzerinden öğrenme ve öğretme süreçlerine odaklanıyoruz.

## Katkıda Bulunma ve Destek

Bu projenin açık kaynak olması, topluluğun aktif katılımını teşvik etmek amacıyla yapılmış bir tercihtir. Eğer projemize katkıda bulunmak istiyorsanız veya herhangi bir sorunla karşılaşırsanız, lütfen bir konu açarak veya bir çekme isteği göndererek bize destek olun. Yeni başlayanlar için uygun bir proje olduğunu düşünüyoruz ve bu nedenle her türlü katkıya açığız.

## Nasıl Başlamalısınız?

## Kurulum

1. Projeyi klonlayın:

   ```bash
   git clone https://github.com/torukmagic/todo-app.git
   ```

2. Proje dizinine gidin:

   ```bash
   cd todo-app
   ```

3. Composer bağımlılıklarını yükleyin:

   ```bash
   composer install
   ```

4. .env.example dosyasını kopyalayarak .env dosyasını oluşturun ve gerekli ayarları yapın.

5. Uygulama anahtarını oluşturun:

   ```bash
   php artisan key:generate
   ```

6. Veritabanını oluşturun:

   ```bash
   php artisan migrate
   ```

7. Geliştirme sunucusunu başlatın:

   ```bash
   php artisan serve
   ```

   Uygulama varsayılan olarak `http://localhost:8000` adresinde çalışacaktır.

## Kullanım

Uygulamayı başlattıktan sonra, tarayıcınızda `http://localhost:8000` adresine giderek yapılacaklarınızı yönetebilirsiniz.

### Temel Fonksiyonlar

- **Yapılacak Ekleme:** Sayfa üzerindeki form aracılığıyla yeni yapılacaklar ekleyebilirsiniz.
  
- **Yapılacak Düzenleme:** Yapılacaklar üzerinde "Düzenle" butonuna tıklayarak mevcut yapılacakları düzenleyebilirsiniz.

- **Yapılacak Silme:** Yapılacaklar üzerinde "Sil" butonuna tıklayarak mevcut yapılacakları silebilirsiniz.

## Teşekkürler

Bu projeye katkıda bulunarak ve kullanarak, Toruk Magic'in bilgi paylaşımına dayalı vizyonunu destekliyorsunuz. Sizlerle birlikte büyümek ve öğrenmek için sabırsızlanıyoruz!

**Toruk Magic - Bilgi Paylaştıkça Çoğalır, Yeni Başlayan Arkadaşlara Yol Gösterir!**
# todo-app
