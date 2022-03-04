using System;
using System.Web;
using System.Text;
using RestSharp;

public partial class _Default : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        int statusCode = 403;
        string p_url = "";
        string response_json = "";
        bool is_valid = false;

        if (!String.IsNullOrWhiteSpace(Request.QueryString["u"]))
        {
            string decodedUrl = HttpUtility.UrlDecode(Request.QueryString["u"]);
            byte[] data = Convert.FromBase64String(decodedUrl);
            string decodedString = Encoding.UTF8.GetString(data);
            p_url = decodedString;
            if (!String.IsNullOrWhiteSpace(p_url))            
                is_valid = true;
            
        }
        
        response_json = "{\"error\":\"parameter is not valid!\"}";
        
        if (is_valid)
        {
            var client = new RestClient(p_url);
            client.Timeout = -1;
            var request = new RestRequest(Method.GET);
            request.AddHeader("Content-Type", "application/json");
            IRestResponse response = client.Execute(request);
            statusCode = (int)response.StatusCode;
            response_json = response.Content;
        }

        Response.Clear();
        Response.StatusCode = statusCode;
        Response.ContentType = "application/json; charset=utf-8";
        Response.Write(response_json);
        Response.End();
    }
}