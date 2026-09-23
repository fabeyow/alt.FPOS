import urllib.request
import os

base_fetch_url = "http://localhost:8081"
github_base_url = "https://fabeyow.github.io/alt.FPOS/"

routes = {
    "/": "index.html",
    "/about": "about/index.html",
    "/customers": "customers/index.html",
    "/users": "users/index.html"
}

def generate():
    for route, file_path in routes.items():
        url = base_fetch_url + route
        print(f"Fetching {url}...")
        try:
            req = urllib.request.Request(url, headers={"User-Agent": "Mozilla/5.0"})
            with urllib.request.urlopen(req) as resp:
                content = resp.read().decode("utf-8")

            # Replace localhost with github pages base url
            content = content.replace("http://localhost:8081/", github_base_url)
            content = content.replace("http://localhost:8081", github_base_url)

            os.makedirs(os.path.dirname(file_path) if os.path.dirname(file_path) else ".", exist_ok=True)
            with open(file_path, "w", encoding="utf-8") as f:
                f.write(content)
            print(f"Saved to {file_path}")
        except Exception as e:
            print(f"Error fetching {url}: {e}")

    # Ensure .nojekyll exists for GitHub Pages
    with open(".nojekyll", "w", encoding="utf-8") as f:
        pass
    print("Created .nojekyll")

if __name__ == "__main__":
    generate()
