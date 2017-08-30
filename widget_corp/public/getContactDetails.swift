func getContactDetails(completion:@escaping () -> Void){

        let url = URL(string: urlString)

        URLSession.shared.dataTask(with:url!) { (data, response, error) in

            if error != nil {
                print(error ?? "")
            }

            else {

                do {
                    let response = try JSONSerialization.jsonObject(with: data!, options: [])
                    self.successGetTermsData(response: response)
                } catch let error as NSError {
                    print(error)
                }

                // uppercase ONLY first letters for accurate sorting
                self.favorites.sort(by: { $0.name.capitalized < $1.name.capitalized })
                self.regulars.sort(by: { $0.name.capitalized < $1.name.capitalized })

            }

            completion()

            }.resume()
    }
