func downloadImage2(url: URL) {

       print("Download Started")

       getDataFromUrl(url: url) { (data, response, error)  in

           //check if ther is data and no errors
           let image = UIImage(data: data!)

           if (image == nil || error != nil) {
               DispatchQueue.main.async() { () -> Void in
                   print("No downloadable Image 2")
                   if (URL(string: self.imgUrl) == url) {
                       self.profileImage.image = UIImage(named: "User Icon Small")
                       return
                   }
               }
           }
           else {
               DispatchQueue.main.async() { () -> Void in
                   if (URL(string: self.imgUrl) == url) {
                       self.profileImage.contentMode = .scaleAspectFit
                       self.profileImage.image = image //UIImage(data: data)
                       self.profileImage.contentMode = .scaleAspectFit
                   }
               }
           }
       }

   }
